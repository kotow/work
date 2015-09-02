<?php
/**
 * @package    cms
 * @subpackage core products
 * @author     Jordan Hristov / Ilya Popivanov
 */

class productsCoreActions extends sfActions
{

	public function executeOrder()
	{
		$this->setLayout(false);
		$this->count = 0;

		if(array_key_exists("cart", $_SESSION))
		{
			$this->count = count($_SESSION["cart"]);
			$products = array();
			foreach ($_SESSION["cart"] as $item)
			{
				$doc = Document::getDocumentInstance($item);
				if($doc) $products[] = $doc;
			}
			$this->products = $products;
			$processPage = Document::getDocumentByExclusiveTag("process_sale_page");
			if($processPage) $this->processPageUrl = $processPage->getHref();
		}
	}

	public function executeCart()
	{
		$this->setLayout(false);
		$this->count = 0;
		if(array_key_exists("cart", $_SESSION))
		{
			$this->count = count($_SESSION["cart"]);
			$products = array();
			foreach ($_SESSION["cart"] as $item)
			{
				$doc = Document::getDocumentInstance($item);
				if($doc) $products[] = $doc;
			}
			$this->products = $products;
		}
		$orderPage = Document::getDocumentByExclusiveTag("order_page");
		if($orderPage) $this->orderPageUrl = $orderPage->getHref();
	}
	
	public function executeAddNum()
	{
		$id = $this->getRequestParameter("id");
		$num = $this->getRequestParameter("num");
		//if(!array_key_exists("cart", $_SESSION) || (array_key_exists("cart", $_SESSION) && !in_array($id, $_SESSION["cart"])))
		{
			$_SESSION["num"][$id] = $num;
			$html = $this->getPresentationFor("products", "order");
		}
		exit($html);
	}

	public function executeCartOrder()
	{
		$this->setLayout(false);
		
		$orderPage = Document::getDocumentByExclusiveTag("order_page");
		if($orderPage) $orderPageUrl = $orderPage->getHref();
		$referer =  $_SERVER['HTTP_REFERER'];
		if($referer == $orderPageUrl)
		{
			$c = new Criteria();
			$cat = CategoryI18nPeer::doSelectOne($c);
			if($cat) $referer = UtilsHelper::cleanURL($cat);
		}
		$this->referer = $referer;
		/*$this->count = 0;
		if(array_key_exists("cart", $_SESSION))
		{
			$this->count = count($_SESSION["cart"]);
			$products = array();
			foreach ($_SESSION["cart"] as $item)
			{
				$doc = Document::getDocumentInstance($item);
				if($doc) $products[] = $doc;
			}
			$this->products = $products;
		}*/
	}

	public function validateProcessSale()
	{
		$result = true;
		if($this->getRequestParameter('submitted') == "submitted")
		{
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll();

			foreach ($params as $key => $param)
			{
				if(!is_array($param))
				{
					${$key} = trim($param);
				}
				else
				{
					${$key} = $param;
				}
			}

			$fields = array(
			"x_first_name" => "",
			"x_last_name" => "",
			"x_address" => "",
			"x_email" => "Email",
			"x_phone" => "",
			"x_zip" => "",
			"x_city" => "",
			"x_state" => "",
			"x_card_type" => "",
			"x_card_num" => "",
			"exp_month" => "",
			"exp_year" => "",
			"x_card_code" => ""
			);

			foreach ($fields as $field => $validator)
			{
				$validatorClass = "";

				$value = $$field;
				if(!$value)
				{
					//echo $field;
					$request->setError('err'.$field, "");
					//$request->setError('err'.$field, UtilsHelper::Localize("website.frontend.No-".$field));
					$result = false;
				}
				elseif($validator && $validator != "Captcha")
				{
					$validatorClass ="sf".$validator."Validator";
					$myValidator = new $validatorClass();
					$myValidator->initialize($this->getContext(), array());
					if($validator == "Email" || $validator == "Url") $value = urldecode($value);
					if (!$myValidator->execute($value, $error))
					{
						$request->setError('err'.$field, UtilsHelper::Localize("website.frontend.Wrong-".$field));
						$result = false;
					}
				}
				elseif ($validator == "Captcha")
				{
					$request = $this->getRequest();
					if($this->getUser()->getAttribute('captcha_code') != $value)
					{
						$request->setError('errcaptcha', UtilsHelper::Localize("website.frontend.Wrong-Captcha"));
						$result = false;
					}
				}
			}
		}
		return $result;
	}

	public function handleErrorProcessSale()
	{
		$this->setLayout(false);
		$request = $this->getRequest();
		$this->errors = $request->getErrors();

		UtilsHelper::setFlashMsg('Please fill all requested fields', UtilsHelper::MSG_ERROR);

		return "Success";
	}

	public function executeProcessSale()
	{
		$this->setLayout(false);
		
		$this->result = false;
		$request = $this->getRequest();
		$request->setParameter('x_exp_date', $this->getRequestParameter("exp_month")."/".$this->getRequestParameter("exp_year"));
		$request->setParameter("exp_month", "");
		$request->setParameter("exp_year", "");
		
		if($this->getRequestParameter("submitted"))
		{
			if(array_key_exists("cart", $_SESSION))
			{
				$products = array();
				foreach ($_SESSION["cart"] as $item)
				{
					$doc = Document::getDocumentInstance($item);
					if($doc)
					{
						
						$cnt = $_SESSION["num"][$item];
						if(!$cnt) $cnt = 1;
						$price = $doc->getPrice();
						$price =  $price*$cnt;
						echo "price:".$price."<br>";
						$totalPrice += $price;
					}
				}
				$totalPrice += round($totalPrice*(UtilsHelper::Settings("taxes")/100), 2);
			}
			
			require_once sfConfig::get('sf_web_dir').'/anet_php_sdk/AuthorizeNet.php';
			
			$transaction = new AuthorizeNetAIM;
			$transaction->setSandbox(AUTHORIZENET_SANDBOX);
			$transaction->setFields(
				array(
					'amount' => $totalPrice,
					'card_num' => $this->getRequestParameter('x_card_num'),
					'exp_date' => $this->getRequestParameter('x_exp_date'),
					'first_name' => $this->getRequestParameter('x_first_name'),
					'last_name' => $this->getRequestParameter('x_last_name'),
					'address' => $this->getRequestParameter('x_address'),
					'email' => $this->getRequestParameter('x_email'),
					'city' => $this->getRequestParameter('x_city'),
					'state' => $this->getRequestParameter('x_state'),
					'country' => $this->getRequestParameter('x_country'),
					'zip' => $this->getRequestParameter('x_zip'),
					'email' => $this->getRequestParameter('x_email'),
					'card_code' => $this->getRequestParameter('x_card_code'),
				)
			);
			
			$transaction->setCustomFields(
				array(
					'products' =>  $this->getRequestParameter('x_delivery_address'),
				)
			);
			$response = $transaction->authorizeAndCapture();
			$this->response = $response;
			
			if(!$this->getRequestParameter('terms'))
			{
				$request->setError('errterms', "Please accept the terms of use");
				UtilsHelper::setFlashMsg('', UtilsHelper::MSG_ERROR);
			}
			else 
			{
				if ($response->approved)
				{
					$this->result = "success";
					$this->transaction_id = $response->transaction_id;
					
					$message = "
					You successfully ordered products from SubcommPools.com<br>
					<br>Date:".date('l jS \of F Y h:i:s A')."<br>
					<br>Transaction number:".$response->transaction_id."<br>
					<br>Name: ".$this->getRequestParameter('x_first_name')." ".$this->getRequestParameter('x_last_name')."<br>
					<br>-------------------<br><br>";
					
					foreach ($_SESSION["cart"] as $item)
					{
						$doc = Document::getDocumentInstance($item);
						if($doc)
						{
							$itemCnt = $_SESSION["num"][$item];
							if(!$itemCnt) $itemCnt = 1;
							$itemPrice = $doc->getPrice();
							$itemPrice =  $itemPrice*$cnt;
							$message .= $doc->getLabel().", Quantity: ".$itemCnt.", $".$itemPrice."<br>";
						}
					}
					
					$message .= "<br>Total+Tax: $".$totalPrice."<br>
					<br>Thank you for your purchase.";
				
					UtilsHelper::sendEmail($this->getRequestParameter('x_email'),$message,"SubcommPools Purchase",UtilsHelper::Settings("main_email"),"SubcommPools",UtilsHelper::Settings("main_email"));
					
					$_SESSION["cart"] = null;
					$_SESSION["num"] = null;
				}
				else
				{
					$this->response_text = $response->response_reason_text;
					//var_dump($response);
					$request->setError('errsubmit', $response->response_reason_text);
					UtilsHelper::setFlashMsg('', UtilsHelper::MSG_ERROR);
					//$this->result = $response->response_reason_text;
					//header('Location: error_page.php?response_reason_code='.$response->response_reason_code.'&response_code='.$response->response_code.'&response_reason_text=' .$response->response_reason_text);
				}
			}
		}

	}

	public function executeAddToCart()
	{
		$id = $this->getRequestParameter("id");
		$html = "";
		if(!array_key_exists("cart", $_SESSION) || (array_key_exists("cart", $_SESSION) && !in_array($id, $_SESSION["cart"])))
		{
			$product = Document::getDocumentInstance($id);
			if($product)
			{
				$_SESSION["cart"][$id] = $id;
				//$html = '<li id="cart_'.$id.'"><span class="cart-name">'.$product->getLabel().'</span><a href="#" id="'.$id.'" class="cart-del">x</a><br class="clear" /></li>';
				$html = "<li id='cart_$id'><span class='cart-name'>".$product->getLabel()."</span><a href='#' del_id='$id' class='cart-del'>x</a><br class='clear' /></li>";
			}
		}
		exit($html);
	}

	public function executeRemoveFromCart()
	{
		$id = $this->getRequestParameter("id");
		unset($_SESSION["cart"][$id]);
		unset($_SESSION["num"][$id]);
		$count = count($_SESSION["cart"]);
		exit("".$count);
	}
	
	public function executeRemoveFromOrder()
	{
		$id = $this->getRequestParameter("id");
		unset($_SESSION["cart"][$id]);
		unset($_SESSION["num"][$id]);
		//$count = count($_SESSION["cart"]);
		$html = $this->getPresentationFor("products", "order");
		exit($html);
	}

	public function executeTopProducts()
	{
		$this->setLayout(false);
		$this->topProducts = Document::getDocumentsByTag("top_product", true, 3);
	}

	public function executeFeaturedProducts()
	{
		$this->setLayout(false);
	}

	public function executeProductDetails()
	{
		$this->setLayout(false);
		$id = $this->getRequestParameter("Product_id");
		$category = $this->category = Document::getParentOf($id); //Document::getParentOf($id, "Category");
		if ($category)
		{
			$this->getRequest()->setParameter("Category_id", $this->category->getId());
		}
		$product = $this->product = Document::getDocumentInstance($id);
		if ($product)
		{
			$this->mainImg = Document::getDocumentInstance($product->getImage());
			$this->images = Document::getChildrenOf($id, "Media");
		}
	}

	public function executeProductsList()
	{
		$this->setLayout(false);
		$id = $this->getRequestParameter("Category_id");
		$category = $this->category = Document::getDocumentInstance($id);
		if ($category)
		{
			$this->products = Document::getChildrenOf($category, "Product", true);
		}
	}

	public function executeProductCategoriesList()
	{
		$this->setLayout(false);
		$c = new Criteria();
		$this->categories = CategoryPeer::doSelect($c);

		$prodNum = array();
		foreach ($this->categories as $cat)
		{
			$id = $cat->getId();
			$products = Document::getChildrenOf($cat, "Product", false);

			// count ACTIVE childrens
			$cnt = 0;
			foreach ($products as $product)
			{
				if ($product->getPublicationStatus() == UtilsHelper::STATUS_ACTIVE)
					$cnt++;
			}
			$prodNum[$id] = $cnt;
		}
		$this->prodNum = $prodNum;
		$this->currentId = $this->getRequestParameter("Category_id");
	}

}