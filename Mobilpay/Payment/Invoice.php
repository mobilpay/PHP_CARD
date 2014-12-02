<?php
/**
 * Class Mobilpay_Payment_Invoice
 * @copyright NETOPIA
 * @author Claudiu Tudose
 * @version 1.0
 *
 */
class Mobilpay_Payment_Invoice
{
	const ERROR_INVALID_PARAMETER			= 0x11110001;
	const ERROR_INVALID_CURRENCY			= 0x11110002;
	const ERROR_ITEM_INSERT_INVALID_INDEX	= 0x11110003;

	const ERROR_LOAD_FROM_XML_CURRENCY_ATTR_MISSING	= 0x31110001;

	public $currency				= null;
	public $amount					= null;
	public $details					= null;
	public $installments			= null;
	public $selectedInstallments	= null;
	public $tokenId			= null;
	public $promotionCode			= null;


	protected $billingAddress	= null;
	protected $shippingAddress	= null;

	protected $items			= array();
	protected $exchangeRates	= array();

	public function __construct(DOMNode $elem = null)
	{
		if($elem != null)
		{
			$this->loadFromXml($elem);
		}
	}

	protected function loadFromXml(DOMNode $elem)
	{
		$attr = $elem->attributes->getNamedItem('currency');
		if($attr == null)
		{
			throw new Exception('Mobilpay_Payment_Invoice::loadFromXml failed; currency attribute missing', self::ERROR_LOAD_FROM_XML_CURRENCY_ATTR_MISSING);
		}
		$this->currency = $attr->nodeValue;

		$attr = $elem->attributes->getNamedItem('amount');
		if($attr != null)
		{
			$this->amount = $attr->nodeValue;
		}

		$attr = $elem->attributes->getNamedItem('installments');
		if($attr != null)
		{
			$this->installments = $attr->nodeValue;
		}

		$attr = $elem->attributes->getNamedItem('selected_installments');
		if($attr != null)
		{
			$this->selectedInstallments = $attr->nodeValue;
		}

		$attr = $elem->attributes->getNamedItem('token_id');
		if($attr != null)
		{
			$this->tokenId = $attr->nodeValue;
		}

		$attr = $elem->attributes->getNamedItem('promotion_code');
		if($attr != null)
		{
			$this->promotionCode = $attr->nodeValue;
		}

		$elems = $elem->getElementsByTagName('details');
		if($elems->length == 1)
		{
			$this->details = urldecode($elems->item(0)->nodeValue);
		}

		$elems = $elem->getElementsByTagName('contact_info');
		if($elems->length == 1)
		{
			$addrElem = $elems->item(0);

			$elems = $addrElem->getElementsByTagName('billing');
			if($elems->length == 1)
			{
				$this->billingAddress = new Mobilpay_Payment_Address($elems->item(0));
			}

			$elems = $addrElem->getElementsByTagName('shipping');
			if($elems->length == 1)
			{
				$this->shippingAddress = new Mobilpay_Payment_Address($elems->item(0));
			}
		}

		$this->items = array();
		$elems = $elem->getElementsByTagName('items');
		if($elems->length == 1)
		{
			$itemElems = $elems->item(0);
			$elems = $itemElems->getElementsByTagName('item');
			if($elems->length > 0)
			{
				$amount = 0;
				foreach ($elems as $itemElem)
				{
					try
					{
						$objItem = new Mobilpay_Payment_Invoice_Item($itemElem);
						$this->items[] = $objItem;
						$amount += $objItem->getTotalAmount();
					}
					catch (Exception $e)
					{
						$e = $e;
						continue;
					}
				}
				$this->amount = $amount;
			}
		}

		$this->exchangeRates = array();
		$elems = $elem->getElementsByTagName('exchange_rates');
		if($elems->length == 1)
		{
			$rateElems = $elems->item(0);
			$elems = $rateElems->getElementsByTagName('rate');
			foreach ($elems as $rateElem)
			{
				try
				{
					$objRate = new Mobilpay_Payment_Exchange_Rate($rateElem);
					$this->exchangeRates[] = $objRate;
				}
				catch (Exception $e)
				{
					$e = $e;
					continue;
				}
			}
		}
	}

	public function createXmlElement(DOMDocument $xmlDoc)
	{
		if(!($xmlDoc instanceof DOMDocument))
		{
			throw new Exception('', self::ERROR_INVALID_PARAMETER);
		}

		$xmlInvElem = $xmlDoc->createElement('invoice');

		if($this->currency == null)
		{
			throw new Exception('Invalid currency', self::ERROR_INVALID_CURRENCY);
		}

		$xmlAttr 			= $xmlDoc->createAttribute('currency');
		$xmlAttr->nodeValue	= $this->currency;
		$xmlInvElem->appendChild($xmlAttr);

		if($this->amount != null)
		{
			$xmlAttr			= $xmlDoc->createAttribute('amount');
			$xmlAttr->nodeValue = sprintf('%.02f', doubleval($this->amount));
			$xmlInvElem->appendChild($xmlAttr);
		}

		if($this->installments != null)
		{
			$xmlAttr			= $xmlDoc->createAttribute('installments');
			$xmlAttr->nodeValue = $this->installments;
			$xmlInvElem->appendChild($xmlAttr);
		}

		if($this->selectedInstallments != null)
		{
			$xmlAttr			= $xmlDoc->createAttribute('selected_installments');
			$xmlAttr->nodeValue = $this->selectedInstallments;
			$xmlInvElem->appendChild($xmlAttr);
		}

		if($this->tokenId != null)
		{
			$xmlAttr			= $xmlDoc->createAttribute('token_id');
			$xmlAttr->nodeValue = $this->tokenId;
			$xmlInvElem->appendChild($xmlAttr);
		}

		if($this->promotionCode != null)
		{
			$xmlAttr			= $xmlDoc->createAttribute('promotion_code');
			$xmlAttr->nodeValue = $this->promotionCode;
			$xmlInvElem->appendChild($xmlAttr);
		}

		if($this->details != null)
		{
			$xmlElem			= $xmlDoc->createElement('details');
			$xmlElem->appendChild($xmlDoc->createCDATASection(urlencode($this->details)));
			$xmlInvElem->appendChild($xmlElem);
		}

		if(($this->billingAddress instanceof Mobilpay_Payment_Address) || ($this->shippingAddress instanceof Mobilpay_Payment_Address))
		{
			$xmlAddr = null;
			if($this->billingAddress instanceof Mobilpay_Payment_Address)
			{
				try
				{
					$xmlElem = $this->billingAddress->createXmlElement($xmlDoc, 'billing');
					if($xmlAddr == null)
					{
						$xmlAddr = $xmlDoc->createElement('contact_info');
					}
					$xmlAddr->appendChild($xmlElem);
				}
				catch(Exception $e)
				{
					$e = $e;
				}
			}
			if($this->shippingAddress instanceof Mobilpay_Payment_Address)
			{
				try
				{
					$xmlElem = $this->shippingAddress->createXmlElement($xmlDoc, 'shipping');
					if($xmlAddr == null)
					{
						$xmlAddr = $xmlDoc->createElement('contact_info');
					}
					$xmlAddr->appendChild($xmlElem);
				}
				catch(Exception $e)
				{
					$e = $e;
				}
			}
			if($xmlAddr != null)
			{
				$xmlInvElem->appendChild($xmlAddr);
			}
		}

		if(is_array($this->items) && sizeof($this->items) > 0)
		{
			$xmlItems = null;
			foreach ($this->items as $item)
			{
				if(!($item instanceof Mobilpay_Payment_Invoice_Item))
				{
					continue;
				}
				try
				{
					$xmlItem = $item->createXmlElement($xmlDoc);
					if($xmlItems == null)
					{
						$xmlItems = $xmlDoc->createElement('items');
					}
					$xmlItems->appendChild($xmlItem);
				}
				catch (Exception $e)
				{
					$e = $e;
				}
			}
			if($xmlItems != null)
			{
				$xmlInvElem->appendChild($xmlItems);
			}
		}

		if(is_array($this->exchangeRates) && sizeof($this->exchangeRates) > 0)
		{
			$xmlRates = null;
			foreach ($this->exchangeRates as $rate)
			{
				if(!($rate instanceof Mobilpay_Payment_Exchange_Rate))
				{
					continue;
				}
				try
				{
					$xmlRate = $rate->createXmlElement($xmlDoc);
					if($xmlRates == null)
					{
						$xmlRates = $xmlDoc->createElement('items');
					}
					$xmlRates->appendChild($xmlRate);
				}
				catch (Exception $e)
				{
					$e = $e;
				}
			}
			if($xmlItems != null)
			{
				$xmlInvElem->appendChild($xmlRates);
			}
		}

		return $xmlInvElem;
	}

	public function setBillingAddress(Mobilpay_Payment_Address $address)
	{
		$this->billingAddress = $address;

		return $this;
	}

	public function setShippingAddress(Mobilpay_Payment_Address $address)
	{
		$this->shippingAddress = $address;

		return $this;
	}

	public function getBillingAddress()
	{
		return $this->billingAddress;
	}

	public function getShippingAddress()
	{
		return $this->shippingAddress;
	}

	public function addHeadItem(Mobilpay_Payment_Invoice_Item $item)
	{
		array_unshift($this->items, $item);

		return $this;
	}

	public function addTailItem(Mobilpay_Payment_Invoice_Item $item)
	{
		array_push($this->items, $item);

		return $this;
	}

	public function removeHeadItem()
	{
		return array_shift($this->items);
	}

	public function removeTailItem()
	{
		return array_pop($this->items);
	}

	public function addHeadExchangeRate(Mobilpay_Payment_Exchange_Rate $rate)
	{
		array_unshift($this->exchangeRates, $rate);

		return $this;
	}

	public function addTailExchangeRate(Mobilpay_Payment_Exchange_Rate $rate)
	{
		array_push($this->exchangeRates, $rate);

		return $this;
	}

	public function removeHeadExchangeRate()
	{
		return array_shift($this->exchangeRates);
	}

	public function removeTailExchangeRate()
	{
		return array_pop($this->exchangeRates);
	}
}
