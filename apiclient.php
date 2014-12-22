<?php
/*
Licensed to the Apache Software Foundation (ASF) under one or more
contributor license agreements.  See the NOTICE file distributed with
this work for additional information regarding copyright ownership.
The ASF licenses this file to You under the Apache License, Version 2.0
(the "License"); you may not use this file except in compliance with
the License.  You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/


define('ECWID_APIV3_URL', "https://app.ecwid.com/api/v3");


/**
 * Instances of this object are returned from ApiClient's method calls. A caller then should call execute()
 * on this object to make the request and return a result.
 */
abstract class ApiRequest {
	/**
	 * A function with signature ($url, $method, $body, $headers)
	 * that executes the HTTP request and returns an ApiResponse object.
	 */
	public $executor;

	public $url;
	public $body;

	public function __construct($executor, $url, HttpEntity $body = null) {
		$this->executor = $executor;
		$this->url = $url;
		$this->body =$body;
	}

	public abstract function execute();

}

class ApiResponse {
	/**
	 * Response data.
	 */
	public $data;

	/**
	 * Response Content-Type, including charset.
	 */
	public $contentType;

	/**
	 * Response headers, assoc array.
	 */
	public $headers;

	public function __construct($data, $contentType, $headers) {
		$this->data = $data;
		$this->contentType = $contentType;
		$this->headers = $headers;
	}
}

class HttpEntity {
	const JSON = "application/json; charset=utf-8";
	const TEXT = "text/plain; charset=utf-8";
	const BINARY = "application/octet-stream";

	public $body;
	public $contentType;

	public function __construct($body, $contentType) {
		$this->body = $body;
		$this->contentType = $contentType;
	}
}

class StatusException extends Exception {
	public function __construct($message, $code) {
		parent::__construct($message, $code);
	}
}

class IllegalArgumentException extends Exception {
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}
}

class EmptyBodyException extends Exception {
	public function __construct($message) {
		parent::__construct($message);
	}
}

class ApiDTO {
	public function __construct($json = null) {
		foreach ($this as $key => $val) {
			unset($this->{$key});
		}
		if ($json != null) {
			foreach ($json as $key => $value) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 * Return an object that can be passed to json_encode()
	 */
	public function asJson() {
		return $this;
	}
}


class ApiDiscountCoupon extends ApiDTO {
	
	/**
	 * Coupon title
	 */
	public $name;
	
	/**
	 * Unique coupon code
	 */
	public $code;
	
	/**
	 * Discount type: ABS, PERCENT or SHIPPING . Default is ABS
	 */
	public $discountType;
	
	/**
	 * Discount coupon state: ACTIVE, PAUSED, EXPIRED or USEDUP . Default is ACTIVE
	 */
	public $status;
	
	/**
	 * Discount amount. 0 is default
	 */
	public $discount;
	
	/**
	 * The date of coupon launch
	 */
	public $launchDate;
	
	/**
	 * Coupon expliration date, e.g. 2014-06-06 08:00:00 +0400
	 */
	public $expirationDate;
	
	/**
	 * The minimum order subtotal the coupon applies to
	 */
	public $totalLimit;
	
	/**
	 * Number of uses limitation: UNLIMITED, ONCEPERCUSTOMER, SINGLE . UNLIMITED is default
	 */
	public $usesLimit;
	
	/**
	 * Coupon usage limitation flag identifying whether the coupon works for all customers or only repeat customers. false is default
	 */
	public $repeatCustomerOnly;
	
	/**
	 * Coupon creation date
	 */
	public $creationDate;
	
	/**
	 * Number of uses
	 */
	public $orderCount;
	
	/**
	 * The products and categories the coupon can be applied to
	 * @var ApiDiscountCouponCatalogLimit
	 */
	public $catalogLimit;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->catalogLimit))
			$this->catalogLimit = new ApiDiscountCouponCatalogLimit($this->catalogLimit);
			
	}
}

class ApiDiscountCouponCatalogLimit extends ApiDTO {
	
	/**
	 * Список идентификаторов товаров, перечисленных через запятую, к которым может быть применен купон
	 */
	public $products;
	
	/**
	 * Список идентификаторов категорий, перечисленных через запятую, к товарам которых может быть применен купон
	 */
	public $categories;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiNotFoundError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiIllegalParameterError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiNonUniqueError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiLimitError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiPaidFeatureError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiAuthError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiValidationError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiFileUploadError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiInternalError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiImportInProgressError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiRetryError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiEntityTooLongError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiUnprocessableImageError extends ApiDTO {
	
	/**
	 * Детальное сообщение об ошибке
	 */
	public $errorMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiDeleteStatus extends ApiDTO {
	
	/**
	 * Количество удаленных сущностей
	 */
	public $deleteCount;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiUpdateStatus extends ApiDTO {
	
	/**
	 * Количество обновленных сущностей
	 */
	public $updateCount;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCreateStatus extends ApiDTO {
	
	/**
	 * Идентификатор созданной сущности
	 */
	public $id;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiUploadStatus extends ApiDTO {
	
	/**
	 * Айдишник залитого к нам файла
	 */
	public $id;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProduct extends ApiDTO {
	
	/**
	 * A unique integer product ID.
	 */
	public $id;
	
	/**
	 * Product SKU, that is, a unique code of the inventory item. Items with different options can have different SKUs, which are specified in the embedded Combination objects.
	 */
	public $sku;
	
	/**
	 * An URL of the product thumbnail. The thumbnail size is specified in the store profile and may be different from the category thumbnail size. This is either an URL of an image uploaded to the /api/v2/STORE-ID/images or an URL of an external resource.
	 */
	public $thumbnailUrl;
	
	/**
	 * Количество товара в стоке. Если количество товара неограничено(unlimited), то данного поля в ответе не будет.
	 */
	public $quantity;
	
	/**
	 * "true", если количество товара не ограничено.
	 */
	public $unlimited;
	
	/**
	 * True если товар есть на складе(количество товара или его комбинаций больше 0, либо если их количество не ограничено)
	 */
	public $inStock;
	
	/**
	 * Product name as a plain text.
	 */
	public $name;
	
	/**
	 * Basic product price.
	 */
	public $price;
	
	/**
	 * The price shown in the product list, which may be different from the basic price if the default product combination overrides the basic price.
	 */
	public $priceInProductList;
	
	/**
	 * The sorted array of (quantity limit, price) pairs.
	 * @var ApiWholesalePrice[]
	 */
	public $wholesalePrices;
	
	/**
	 * 'Compare To' price shown strike-out in the customer frontend.
	 */
	public $compareToPrice;
	
	/**
	 * Is shipping required for this product delivery
	 */
	public $isShippingRequired;
	
	/**
	 * Product weight, in the store units. Absent for intangible products.
	 */
	public $weight;
	
	/**
	 * URL of the product's description web page.
	 */
	public $url;
	
	/**
	 * Product creation date/time.
	 */
	public $created;
	
	/**
	 * Product last update date/time. Can be null for products that were created before this.
	 */
	public $updated;
	
	/**
	 * Id of a product class this product belongs to (like 'Books'). Zero '0' value means 'General' class, which is the default for new products. Product classes have additional attributes you can see on the 'Attributes' tab in the product editor.
	 */
	public $productClassId;
	
	/**
	 * 'true' if product is enabled, 'false' otherwise. Disabled products do not show in the customer frontend.
	 */
	public $enabled;
	
	/**
	 * A list of the product options. Empty if no options are specified for the product.
	 * @var ApiProductOption[]
	 */
	public $options;
	
	/**
	 * The value of the 'Send me a note when quantity in stock reaches' field.
	 */
	public $warningLimit;
	
	/**
	 * True if the shipping is calculated as 'Fixed rate per item' (see Tax and Shipping / Shipping freight in the product editor). With this option on, global shipping settings do not affect the shipping rate of the item. The fixedShippingRate field is than specifies the shipping cost.
	 */
	public $fixedShippingRateOnly;
	
	/**
	 * For fixedShippingRateOnly=true, this value is used instead of the shipping. For fixedShippingRateOnly=false, this value adds to the shipping cost.
	 */
	public $fixedShippingRate;
	
	/**
	 * Id of a combination corresponding to the default product option values. E.g. if the default t-shirt color is 'white', and there is a separate combination for the white t-shirts, that combination is returned.
	 */
	public $defaultCombinationId;
	
	/**
	 * An URL of a product image that must be shown to the user. If the original image is greater then 500x500 pixels, it is resized to make it smaller. The original image is always available under the originalImageUrl field of a Product. This is either an URL of an image uploaded to the /api/v2/STORE-ID/images or an URL of an external resource.
	 */
	public $imageUrl;
	
	/**
	 * An URL of the product thumbnail fitted in the 80x80 box.
	 */
	public $smallThumbnailUrl;
	
	/**
	 * An URL of an original product image that was uploaded for this product.
	 */
	public $originalImageUrl;
	
	/**
	 * Product description in HTML.
	 */
	public $description;
	
	/**
	 * A list of gallery images.
	 * @var ApiGalleryImage[]
	 */
	public $galleryImages;
	
	/**
	 * A list of categories which this product belongs to.
	 */
	public $categoryIds;
	
	/**
	 * Id of a category marked by a store owner as 'default' for this product. Default category shows up in a product page when no category id is given in the URL.
	 */
	public $defaultCategoryId;
	
	/**
	 * Количество добавлений в избранное. Возвращается если фича favorites включена.
	 * @var ApiFavorites
	 */
	public $favorites;
	
	/**
	 * If present, contains product's attributes values (see the description of object Attribute below). You can edit the attribute values on the 'Attributes' tab in the product editor.
	 * @var ApiAttributeValue[]
	 */
	public $attributes;
	
	/**
	 * E-goods attached to the product. This field is only available for authorized requests.
	 * @var ApiProductFile[]
	 */
	public $files;
	
	/**
	 * The configuration of related products, as shown in the 'Related Products' tab of the Product Editor.
	 * @var ApiRelatedProducts
	 */
	public $relatedProducts;
	
	/**
	 * This can only be used when product retrieval. This field is absent on saving a product.
	 * @var ApiCombination[]
	 */
	public $combinations;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->wholesalePrices))
			
			for ($i=0; $i < count($this->wholesalePrices); $i++)
				if (isset($this->wholesalePrices[$i]))
					$this->wholesalePrices[$i] = new ApiWholesalePrice($this->wholesalePrices[$i]);
			
		if (isset($this->options))
			
			for ($i=0; $i < count($this->options); $i++)
				if (isset($this->options[$i]))
					$this->options[$i] = new ApiProductOption($this->options[$i]);
			
		if (isset($this->galleryImages))
			
			for ($i=0; $i < count($this->galleryImages); $i++)
				if (isset($this->galleryImages[$i]))
					$this->galleryImages[$i] = new ApiGalleryImage($this->galleryImages[$i]);
			
		if (isset($this->favorites))
			$this->favorites = new ApiFavorites($this->favorites);
			
		if (isset($this->attributes))
			
			for ($i=0; $i < count($this->attributes); $i++)
				if (isset($this->attributes[$i]))
					$this->attributes[$i] = new ApiAttributeValue($this->attributes[$i]);
			
		if (isset($this->files))
			
			for ($i=0; $i < count($this->files); $i++)
				if (isset($this->files[$i]))
					$this->files[$i] = new ApiProductFile($this->files[$i]);
			
		if (isset($this->relatedProducts))
			$this->relatedProducts = new ApiRelatedProducts($this->relatedProducts);
			
		if (isset($this->combinations))
			
			for ($i=0; $i < count($this->combinations); $i++)
				if (isset($this->combinations[$i]))
					$this->combinations[$i] = new ApiCombination($this->combinations[$i]);
			
	}
}

class ApiFavorites extends ApiDTO {
	
	/**
	 * Количества добавлений в избранное числом как есть
	 */
	public $count;
	
	/**
	 * Краткое текстовое представление количества добавлений в избранное. Например: 123, 4k, 5.3M
	 */
	public $displayedCount;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiRelatedProducts extends ApiDTO {
	
	/**
	 * IDs of the related products. May contain ids of removed products, in which case the removed ids should be disregarded.
	 */
	public $productIds;
	
	/**
	 * Specifies the random number of related products from a given category.
	 * @var ApiRelatedCategory
	 */
	public $relatedCategory;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->relatedCategory))
			$this->relatedCategory = new ApiRelatedCategory($this->relatedCategory);
			
	}
}

class ApiRelatedCategory extends ApiDTO {
	
	/**
	 * Флаг включенности выбора связанных товаров из категории
	 */
	public $enabled;
	
	/**
	 * Id of a category whose products you wish to add as related products. Zero value means "any category", that is, just random products.
	 */
	public $categoryId;
	
	/**
	 * Number of random products from a given category (or from all store, if categoryId==0), which should be shown as a related products of a given product.
	 */
	public $productCount;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiWholesalePrice extends ApiDTO {
	
	/**
	 * Number of items for which the special price is eligible.
	 */
	public $quantity;
	
	/**
	 * Special price for the product when ordered more the 'quantity' items.
	 */
	public $price;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiGalleryImage extends ApiDTO {
	
	/**
	 * The image identificator
	 */
	public $id;
	
	/**
	 * The image description, displayed in 'alt' image attribute, as a plain text.
	 */
	public $alt;
	
	/**
	 * The image url.
	 */
	public $url;
	
	/**
	 * An URL of the image thumbnail fit into the 46x42 box.
	 */
	public $thumbnail;
	
	/**
	 * Width of the image.
	 */
	public $width;
	
	/**
	 * Height of the image.
	 */
	public $height;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProductFile extends ApiDTO {
	
	/**
	 * Unique integer file ID.
	 */
	public $id;
	
	/**
	 * A plain-text file name.
	 */
	public $name;
	
	/**
	 * A plain-text file description.
	 */
	public $description;
	
	/**
	 * File size, in bytes, as a 64-bit integer.
	 */
	public $size;
	
	/**
	 * Ссылка на egood, которой не касаются никакие лимиты. Отдавать эту ссылку кастомеру не стоит, ибо содержит токен для доступа в админку магазина
	 */
	public $adminUrl;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCombination extends ApiDTO {
	
	/**
	 * A unique integer combination ID.
	 */
	public $id;
	
	/**
	 * A positive integer number, unique to the product, shown in the combinations table in the
     * product editor.
	 */
	public $combinationNumber;
	
	/**
	 * Set of options which identifies this combination. An array of {name:, value:} objects.
	 * @var ApiOptionValue[]
	 */
	public $options;
	
	/**
	 * If present, combination SKU, unique code. If null, product sku is assumed.
	 */
	public $sku;
	
	/**
	 * An URL of the product combination thumbnail fitted in the 80x80 box.   If null, product thumbnail is assumed.
	 */
	public $smallThumbnailUrl;
	
	/**
	 * An URL of the product combination thumbnail. The thumbnail size is specified in the store profile and
     * may be different from the category thumbnail size.  If null, product thumbnail is assumed.
	 */
	public $thumbnailUrl;
	
	/**
	 * An URL of a combination image that must be shown to the user. If the original image is greater
     * then 500x500 pixels, it is resized to make it smaller. The original image is always available under the
     * originalImageUrl field of a Product.  If null, product image is assumed.
	 */
	public $imageUrl;
	
	/**
	 * An URL of a non-resized combination image that was uploaded for this combination. 
     * If null, product image is assumed.
	 */
	public $originalImageUrl;
	
	/**
	 * Количество товара данной комбинации на складе. 
     * Если значение товарных остатков для конкретной комбинации не задано, то возвращаться будет значение остатков исходного продукта.
     * Если количество товара неограничено(unlimited), то данного поля в ответе не будет.
	 */
	public $quantity;
	
	/**
	 * "true", если количество товара не ограничено.
	 */
	public $unlimited;
	
	/**
	 * Price of the product having the specified option values. If null, basic product price is assumed.
	 */
	public $price;
	
	/**
	 * The sorted array of (quantity limit, price) pairs. If null, no wholesale prices are assumed
     * and 'price' field takes place.
	 * @var ApiWholesalePrice[]
	 */
	public $wholesalePrices;
	
	/**
	 * True if the combination has its own weight that overrides the product's weight. False if the combination is intangible (no shipping required).
     * Null if the weight should be inherited from the product.
	 */
	public $isShippingRequired;
	
	/**
	 * Product weight, in the store units. If null, the weight is inherited from the product.
	 */
	public $weight;
	
	/**
	 * The value of the 'Send me a note when quantity in stock reaches' field. If null, product's
     * limit is used.
	 */
	public $warningLimit;
	
	/**
	 * Specifies amount by which to increase the combination's inventory in stock (for PUT requests). Negative number decreases inventory.
	 */
	public $inventoryDelta;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->options))
			
			for ($i=0; $i < count($this->options); $i++)
				if (isset($this->options[$i]))
					$this->options[$i] = new ApiOptionValue($this->options[$i]);
			
		if (isset($this->wholesalePrices))
			
			for ($i=0; $i < count($this->wholesalePrices); $i++)
				if (isset($this->wholesalePrices[$i]))
					$this->wholesalePrices[$i] = new ApiWholesalePrice($this->wholesalePrices[$i]);
			
	}
}

class ApiOptionValue extends ApiDTO {
	
	/**
	 * Option name, as in Product.options[i].name
	 */
	public $name;
	
	/**
	 * Option value one of Product.options[i].choices[j].text
	 */
	public $value;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProductOption extends ApiDTO {
	
	/**
	 * Тип продуктовой опции
	 */
	public $type;
	
	/**
	 * Option name, like 'Color', as a plain text.
	 */
	public $name;
	
	/**
	 * All possible option choices, if the type is 'SELECT', 'CHECKBOX' or 'RADIO'. Absent otherwise. Default is empty
	 * @var ApiProductOptionChoice[]
	 */
	public $choices;
	
	/**
	 * The number, starting from 0, of the default choice. Only present if the type is 'SELECT', 'CHECKBOX' or 'RADIO'.
	 */
	public $defaultChoice;
	
	/**
	 * "true" if this option is required, "false" otherwise. Default is false
	 */
	public $required;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->choices))
			
			for ($i=0; $i < count($this->choices); $i++)
				if (isset($this->choices[$i]))
					$this->choices[$i] = new ApiProductOptionChoice($this->choices[$i]);
			
	}
}

class ApiProductOptionChoice extends ApiDTO {
	
	/**
	 * A text displayed as a choice in a drop-down or a radio box, e.g. 'Green'.
	 */
	public $text;
	
	/**
	 * Number of percents or currency units to add to the product price when this choice is selected. May be negative or zero. Default is 0
	 */
	public $priceModifier;
	
	/**
	 * Specifies the way the product price is modified. If 'PERCENT', then priceModifier is a number of percents to add to the price. If 'ABSOLUTE', then priceModifier is a number of currency units to add to the price.
	 */
	public $priceModifierType;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProductClass extends ApiDTO {
	
	/**
	 * Unique integer product class ID. Zero '0' for the built-in 'General' class applied to products by default.
	 */
	public $id;
	
	/**
	 * The name of the product class. This field is absent for the 'General' product class.
	 */
	public $name;
	
	/**
	 * Google-таксономия, которой соответствует данный продуктовый класс
	 */
	public $googleTaxonomy;
	
	/**
	 * Id таксономии для eBay
	 */
	public $ebayTaxonomyId;
	
	/**
	 * Id кондиции для eBay
	 */
	public $ebayCondition;
	
	/**
	 * An array of product class attributes, e.g. 'ISBN' for Books.
	 * @var ApiAttribute[]
	 */
	public $attributes;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->attributes))
			
			for ($i=0; $i < count($this->attributes); $i++)
				if (isset($this->attributes[$i]))
					$this->attributes[$i] = new ApiAttribute($this->attributes[$i]);
			
	}
}

class ApiAttribute extends ApiDTO {
	
	/**
	 * Unique integer attribute ID.
	 */
	public $id;
	
	/**
	 * The name of the attribute, like 'ISBN', as shown in the store front-end. Plain text.
	 */
	public $name;
	
	/**
	 * Attribute type. 'CUSTOM' attributes can be added or removed. Other types are built-ins, thus you cannot remove those fields.
	 */
	public $type;
	
	/**
	 * Controls the visibility and location of the attribute value on the product page.
	 */
	public $show;
	
	/**
	 * 
	 */
	public $internalName;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiAttributeValue extends ApiDTO {
	
	/**
	 * Unique attribute ID, as found in the /api/v3/[STORE-ID]/classes/[ID].
	 */
	public $id;
	
	/**
	 * Алиас атрибута, может принимать значение BRAND, UPC. Используется для облегченного создания/редактирования атрибутов продукта
	 */
	public $alias;
	
	/**
	 * The attribute's printable name
	 */
	public $name;
	
	/**
	 * The attribute value. Set to null in product update request to remove the attribute.
	 */
	public $value;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCategory extends ApiDTO {
	
	/**
	 * A unique integer category ID.
	 */
	public $id;
	
	/**
	 * An ID of the parent category, if any. This key is absent for root categories.
	 */
	public $parentId;
	
	/**
	 * Position of this category in the parent category. OrderBys may not be
     * sequential. Categories are returned in ascending order.
	 */
	public $orderBy;
	
	/**
	 * An URL of the category thumbnail. The thumbnail size is specified in the store profile. This is either an URL of an image uploaded to the /api/v2/STORE-ID/images or an URL of an external resource.
	 */
	public $thumbnailUrl;
	
	/**
	 * An URL of the non-resized category image originally uploaded as a thumbnail. This is either an URL of an image uploaded to the /api/v2/STORE-ID/images or an URL of an external resource.
	 */
	public $originalImageUrl;
	
	/**
	 * Category name, plain text.
	 */
	public $name;
	
	/**
	 * URL of the category.
	 */
	public $url;
	
	/**
	 * Number of products in the category and its subcategories.
	 */
	public $productCount;
	
	/**
	 * The category description in HTML. Null in category list request (/categories). Can also be
     * null if no description is set for the category.
	 */
	public $description;
	
	/**
	 * "true" if the category is enabled, "false" otherwise. Enabled categories show in a category
     * list in storefront.
	 */
	public $enabled;
	
	/**
	 * Products that should be included in the category. This field can be null, if category
     * products should not be returned or changed.
	 */
	public $productIds;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiOrder extends ApiDTO {
	
	/**
	 * Идентификатор заказа спецефичный для магазина мерчанта
	 */
	public $vendorOrderNumber;
	
	/**
	 * Стоимость итемов без налогов, скидок и доставки, в валюте магазина
	 */
	public $subtotal;
	
	/**
	 * Стоимость итемов c учетом налогов, скидок и доставки, в валюте магазина
	 */
	public $total;
	
	/**
	 * E-mail пользователя
	 */
	public $email;
	
	/**
	 * Идентификатор заказа во внешней платежной системе
	 */
	public $externalTransactionId;
	
	/**
	 * Платежный модуль, через который осуществлен платеж
	 */
	public $paymentModule;
	
	/**
	 * Платежный метод, через который осуществлен платеж
	 */
	public $paymentMethod;
	
	/**
	 * Сумма налогов в валюте магазина
	 */
	public $tax;
	
	/**
	 * IP-адрес покупателя
	 */
	public $ipAddress;
	
	/**
	 * Скидка, полученная по купону
	 */
	public $couponDiscount;
	
	/**
	 * Номер трекинга для посылки
	 */
	public $trackingNumber;
	
	/**
	 * Статус платежа
	 */
	public $paymentStatus;
	
	/**
	 * Сообщение об ошибке или предупреждение, возвращенное платежной системой.
	 */
	public $paymentMessage;
	
	/**
	 * Статус выполнения заказа.
	 */
	public $fulfillmentStatus;
	
	/**
	 * Номер заказа
	 */
	public $orderNumber;
	
	/**
	 * Адрес страницы, с которой сделан заказ
	 */
	public $refererUrl;
	
	/**
	 * Примечания, которые указывает покупатель при заказе.
	 */
	public $notes;
	
	/**
	 * Комментарий мерчанта к заказу
	 */
	public $orderComments;
	
	/**
	 * 
	 */
	public $affiliateId;
	
	/**
	 * Скидка в зависимости от размера тотала
	 */
	public $volumeDiscount;
	
	/**
	 * Идентификатор покупателя
	 */
	public $customerId;
	
	/**
	 * Скидка в зависимости от группы покупателей
	 */
	public $membershipBasedDiscount;
	
	/**
	 * Скидка в зависимости от группы и суммы покупателей
	 */
	public $totalAndMembershipBasedDiscount;
	
	/**
	 * Скидка
	 */
	public $discount;
	
	/**
	 * Цена заказа в долларах
	 */
	public $usdTotal;
	
	/**
	 * Адрес сайта с которого пришел покупатель в магазин
	 */
	public $globalReferer;
	
	/**
	 * Дата создания заказа
	 */
	public $createDate;
	
	/**
	 * Дата последнего изменения заказа
	 */
	public $updateDate;
	
	/**
	 * Название группы, в которую включен покупатель из данного заказа
	 */
	public $customerGroup;
	
	/**
	 * Примененый купон
	 * @var ApiDiscountCoupon
	 */
	public $discountCoupon;
	
	/**
	 * Список товаров заказа
	 * @var ApiOrderItem[]
	 */
	public $items;
	
	/**
	 * Адрес плательщика
	 * @var ApiPerson
	 */
	public $billingPerson;
	
	/**
	 * Адрес доставки
	 * @var ApiPerson
	 */
	public $shippingPerson;
	
	/**
	 * Свойства доставки
	 * @var ApiShippingOption
	 */
	public $shippingOption;
	
	/**
	 * Дополнительная информация о заказе
	 */
	public $additionalInfo;
	
	/**
	 * Информация передаваемая в платежки
	 */
	public $paymentParams;
	
	/**
	 * Информация о скидках
	 * @var ApiDiscount[]
	 */
	public $discountInfo;
	
	/**
	 * Информация о кредитной карте
	 * @var ApiCreditCardStatus
	 */
	public $creditCardStatus;
	
	/**
	 * Идентификатор заказа в ebay
	 */
	public $ebayId;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->discountCoupon))
			$this->discountCoupon = new ApiDiscountCoupon($this->discountCoupon);
			
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiOrderItem($this->items[$i]);
			
		if (isset($this->billingPerson))
			$this->billingPerson = new ApiPerson($this->billingPerson);
			
		if (isset($this->shippingPerson))
			$this->shippingPerson = new ApiPerson($this->shippingPerson);
			
		if (isset($this->shippingOption))
			$this->shippingOption = new ApiShippingOption($this->shippingOption);
			
		if (isset($this->discountInfo))
			
			for ($i=0; $i < count($this->discountInfo); $i++)
				if (isset($this->discountInfo[$i]))
					$this->discountInfo[$i] = new ApiDiscount($this->discountInfo[$i]);
			
		if (isset($this->creditCardStatus))
			$this->creditCardStatus = new ApiCreditCardStatus($this->creditCardStatus);
			
	}
}

class ApiShippingOption extends ApiDTO {
	
	/**
	 * Название поставщика
	 */
	public $shippingCarrierName;
	
	/**
	 * Название метода
	 */
	public $shippingMethodName;
	
	/**
	 * Ставка шипинга
	 */
	public $shippingRate;
	
	/**
	 * Время доставки
	 */
	public $estimatedTransitTime;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiPerson extends ApiDTO {
	
	/**
	 * Имя
	 */
	public $name;
	
	/**
	 * Название фирмы
	 */
	public $companyName;
	
	/**
	 * Улица
	 */
	public $street;
	
	/**
	 * Город
	 */
	public $city;
	
	/**
	 * Код страны
	 */
	public $countryCode;
	
	/**
	 * Название страны
	 */
	public $countryName;
	
	/**
	 * Почтовый индекс
	 */
	public $postalCode;
	
	/**
	 * Код штата
	 */
	public $stateOrProvinceCode;
	
	/**
	 * Название штата
	 */
	public $stateOrProvinceName;
	
	/**
	 * Номер телефона
	 */
	public $phone;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProductSearchResult extends ApiDTO {
	
	/**
	 * Общее количество продуктов, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество продуктов в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество продуктов, возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных продуктов
	 * @var ApiProductEntry[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiProductEntry($this->items[$i]);
			
	}
}

class ApiCategorySearchResult extends ApiDTO {
	
	/**
	 * Общее количество категорий, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество категорий в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество категорий, возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных категорий
	 * @var ApiCategory[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiCategory($this->items[$i]);
			
	}
}

class ApiOrderSearchResult extends ApiDTO {
	
	/**
	 * Общее количество заказов, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество заказов в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество заказов, возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных заказов
	 * @var ApiOrder[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiOrder($this->items[$i]);
			
	}
}

class ApiCustomerSearchResult extends ApiDTO {
	
	/**
	 * Общее количество покупателей, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество покупателей в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество покупателей, возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных покупателей
	 * @var ApiCustomerSearchEntry[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiCustomerSearchEntry($this->items[$i]);
			
	}
}

class ApiDiscountCouponResult extends ApiDTO {
	
	/**
	 * Общее количество купонов, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество купонов в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество купонов возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных купонов
	 * @var ApiDiscountCoupon[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiDiscountCoupon($this->items[$i]);
			
	}
}

class ApiProductEntry extends ApiDTO {
	
	/**
	 * Айдишник продукта
	 */
	public $id;
	
	/**
	 * Product SKU, that is, a unique code of the inventory item. Items with different options can have different SKUs, which are specified in the embedded Combination objects.
	 */
	public $sku;
	
	/**
	 * An URL of the product smallThumbnail.
	 */
	public $smallThumbnailUrl;
	
	/**
	 * An URL of the product thumbnail. The thumbnail size is specified in the store profile and may be different from the category thumbnail size. This is either an URL of an image uploaded to the /api/v3/STORE-ID/images or an URL of an external resource.
	 */
	public $thumbnailUrl;
	
	/**
	 * If present, an URL of a product image
	 */
	public $imageUrl;
	
	/**
	 * An URL of an original product image that was uploaded for this product.
	 */
	public $originalImageUrl;
	
	/**
	 * Количество товара в стоке. Если количество товара неограничено(unlimited), то данного поля в ответе не будет.
	 */
	public $quantity;
	
	/**
	 * "true", если количество товара не ограничено.
	 */
	public $unlimited;
	
	/**
	 * True если товар есть на складе(количество товара или его комбинаций больше 0, либо если их количество не ограничено)
	 */
	public $inStock;
	
	/**
	 * Product name as a plain text.
	 */
	public $name;
	
	/**
	 * Basic product price.
	 */
	public $price;
	
	/**
	 * 'Compare To' price shown strike-out in the customer frontend.
	 */
	public $compareToPrice;
	
	/**
	 * Product weight, in the store units. Absent for intangible products.
	 */
	public $weight;
	
	/**
	 * URL of the product's description web page.
	 */
	public $url;
	
	/**
	 * Product creation date/time.
	 */
	public $created;
	
	/**
	 * Product last update date/time. Can be null for products that were created before this.
	 */
	public $updated;
	
	/**
	 * Id of a product class this product belongs to (like 'Books'). Zero '0' value means 'General' class, which is the default for new products. Product classes have additional attributes you can see on the 'Attributes' tab in the product editor.
	 */
	public $productClassId;
	
	/**
	 * 'true' if product is enabled, 'false' otherwise. Disabled products do not show in the customer frontend.
	 */
	public $enabled;
	
	/**
	 * Product description in HTML.
	 */
	public $description;
	
	/**
	 * Было ли обрезано поле description
	 */
	public $descriptionTruncated;
	
	/**
	 * The price shown in the product list, which may be different from the basic price if the default product combination overrides the basic price.
	 */
	public $priceInProductList;
	
	/**
	 * Set of options which identifies this combination. An array of {name:, value:} objects.
	 * @var ApiProductEntryCombination
	 */
	public $defaultCombination;
	
	/**
	 * A list of categories which this product belongs to.
	 */
	public $categoryIds;
	
	/**
	 * Id of a category marked by a store owner as 'default' for this product. Default category shows up in a product page when no category id is given in the URL.
	 */
	public $defaultCategoryId;
	
	/**
	 * Количество добавлений в избранное. Возвращается если фича favorites включена.
	 * @var ApiFavorites
	 */
	public $favorites;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->defaultCombination))
			$this->defaultCombination = new ApiProductEntryCombination($this->defaultCombination);
			
		if (isset($this->favorites))
			$this->favorites = new ApiFavorites($this->favorites);
			
	}
}

class ApiProductEntryCombination extends ApiDTO {
	
	/**
	 * Идентификатор комбинации
	 */
	public $id;
	
	/**
	 * Артикул комбинации
	 */
	public $sku;
	
	/**
	 * Количество товара данной комбинации на складе.
     * Если значение товарных остатков для конкретной комбинации не задано, то возвращаться будет значение остатков исходного продукта.
     * Если количество товара неограничено(unlimited), то данного поля в ответе не будет.
	 */
	public $quantity;
	
	/**
	 * "true", если количество товара не ограничено.
	 */
	public $unlimited;
	
	/**
	 * Цена комбинации товара
	 */
	public $price;
	
	/**
	 * Вес комбинации товара
	 */
	public $weight;
	
	/**
	 * An URL of the product smallThumbnail.
	 */
	public $smallThumbnailUrl;
	
	/**
	 * An URL of the product thumbnail. The thumbnail size is specified in the store profile and may be different from the category thumbnail size. This is either an URL of an image uploaded to the /api/v3/STORE-ID/images or an URL of an external resource.
	 */
	public $thumbnailUrl;
	
	/**
	 * If present, an URL of a product image
	 */
	public $imageUrl;
	
	/**
	 * Set of options which identifies this combination. An array of {name:, value:} objects.
	 * @var ApiOptionValue[]
	 */
	public $combination;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->combination))
			
			for ($i=0; $i < count($this->combination); $i++)
				if (isset($this->combination[$i]))
					$this->combination[$i] = new ApiOptionValue($this->combination[$i]);
			
	}
}

class ApiDiscount extends ApiDTO {
	
	/**
	 * Значение скидки
	 */
	public $value;
	
	/**
	 * Тип скидки
	 */
	public $type;
	
	/**
	 * Основание для скидки
	 */
	public $base;
	
	/**
	 * Минимальная величина суммы заказа, для которого применима скидка
	 */
	public $orderTotal;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiOrderItemProductOption extends ApiDTO {
	
	/**
	 * Имя опции
	 */
	public $name;
	
	/**
	 * Значение опции(для типа FILE будет пустым)
	 */
	public $value;
	
	/**
	 * Тип продуктовой опции
	 */
	public $type;
	
	/**
	 * Приаттаченные файлы. Применимо только для опции типа FILES
	 * @var ApiOrderItemOptionFile[]
	 */
	public $files;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->files))
			
			for ($i=0; $i < count($this->files); $i++)
				if (isset($this->files[$i]))
					$this->files[$i] = new ApiOrderItemOptionFile($this->files[$i]);
			
	}
}

class ApiOrderItemOptionFile extends ApiDTO {
	
	/**
	 * Айдишник файла
	 */
	public $id;
	
	/**
	 * Имя файла
	 */
	public $name;
	
	/**
	 * Размер файла
	 */
	public $size;
	
	/**
	 * Урл по которому доступен файл
	 */
	public $url;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiOrderItemProductFile extends ApiDTO {
	
	/**
	 * Айдишник продуктового файла
	 */
	public $productFileId;
	
	/**
	 * Максимальное количество скачек
	 */
	public $maxDownloads;
	
	/**
	 * Использованное количество скачек
	 */
	public $remainingDownloads;
	
	/**
	 * Время окончания жизни файла
	 */
	public $expire;
	
	/**
	 * Название файла
	 */
	public $name;
	
	/**
	 * Описание файла.
	 */
	public $description;
	
	/**
	 * Размер файла в байтах.
	 */
	public $size;
	
	/**
	 * Ссылка на egood, которой не касаются никакие лимиты. Отдавать эту ссылку кастомеру не стоит, ибо содержит токен для доступа в админку магазина
	 */
	public $adminUrl;
	
	/**
	 * Ссылка на egood для кастомера, на нее действуют все заданные лимиты.
	 */
	public $customerUrl;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiOrderItemTax extends ApiDTO {
	
	/**
	 * Название налога
	 */
	public $name;
	
	/**
	 * Значение налога
	 */
	public $value;
	
	/**
	 * Сумма налога
	 */
	public $total;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiOrderItem extends ApiDTO {
	
	/**
	 * Идентификатор товара в заказе
	 */
	public $id;
	
	/**
	 * Ссылка на продукт
	 */
	public $productId;
	
	/**
	 * Ссылка на категорию
	 */
	public $categoryId;
	
	/**
	 * Цена товара в корзине
	 */
	public $price;
	
	/**
	 * Базовая цена продукта без учета опций и оптовых цен, в валюте магазина
	 */
	public $productPrice;
	
	/**
	 * СКУ
	 */
	public $sku;
	
	/**
	 * Количество единиц товара
	 */
	public $quantity;
	
	/**
	 * Короткое описание товара
	 */
	public $shortDescription;
	
	/**
	 * Налог
	 */
	public $tax;
	
	/**
	 * Цена доставки
	 */
	public $shipping;
	
	/**
	 * Количество товара в наличии
	 */
	public $quantityInStock;
	
	/**
	 * Название товара
	 */
	public $name;
	
	/**
	 * Требует ли доставки
	 */
	public $isShippingRequired;
	
	/**
	 * Вес
	 */
	public $weight;
	
	/**
	 * Отслеживать доставку
	 */
	public $trackQuantity;
	
	/**
	 * Только фиксированная стоимость доставки
	 */
	public $fixedShippingRateOnly;
	
	/**
	 * Ссылка на картинку
	 */
	public $imageUrl;
	
	/**
	 * Цена фиксированной доставки
	 */
	public $fixedShippingRate;
	
	/**
	 * Цифровой товар
	 */
	public $digital;
	
	/**
	 * Доступиен ли товар
	 */
	public $productAvailable;
	
	/**
	 * Применен ли купон на скидку
	 */
	public $couponApplied;
	
	/**
	 * Выбранные опции
	 * @var ApiOrderItemProductOption[]
	 */
	public $selectedOptions;
	
	/**
	 * Прикрепленные к товару файлы
	 * @var ApiOrderItemProductFile[]
	 */
	public $files;
	
	/**
	 * Скидки
	 * @var ApiOrderItemTax[]
	 */
	public $taxes;
	
	/**
	 * Идентификатор товара в ebay
	 */
	public $ebayId;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->selectedOptions))
			
			for ($i=0; $i < count($this->selectedOptions); $i++)
				if (isset($this->selectedOptions[$i]))
					$this->selectedOptions[$i] = new ApiOrderItemProductOption($this->selectedOptions[$i]);
			
		if (isset($this->files))
			
			for ($i=0; $i < count($this->files); $i++)
				if (isset($this->files[$i]))
					$this->files[$i] = new ApiOrderItemProductFile($this->files[$i]);
			
		if (isset($this->taxes))
			
			for ($i=0; $i < count($this->taxes); $i++)
				if (isset($this->taxes[$i]))
					$this->taxes[$i] = new ApiOrderItemTax($this->taxes[$i]);
			
	}
}

class ApiCreditCardStatus extends ApiDTO {
	
	/**
	 * Строка AVS(Результат проверки адреса)
	 */
	public $avsMessage;
	
	/**
	 * Строка CVV(Результат проверки кода верификации)
	 */
	public $cvvMessage;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiProfile extends ApiDTO {
	
	/**
	 * Основные данные профиля
	 * @var ApiGeneralInfo
	 */
	public $generalInfo;
	
	/**
	 * Данные об аккаунте пользователя
	 * @var ApiAccountInfo
	 */
	public $account;
	
	/**
	 * Данные о магазине
	 * @var ApiStoreSettings
	 */
	public $settings;
	
	/**
	 * Данные о компании
	 * @var ApiCompany
	 */
	public $company;
	
	/**
	 * Данные о форматах данных используемых в магазине
	 * @var ApiFormatsAndUnits
	 */
	public $formatsAndUnits;
	
	/**
	 * Данные о форматах данных используемых в магазине
	 * @var ApiLanguages
	 */
	public $languages;
	
	/**
	 * Список налогов магазина
	 * @var ApiTax[]
	 */
	public $taxes;
	
	/**
	 * Список зон данного магазина
	 * @var ApiZone[]
	 */
	public $zones;
	
	/**
	 * Данные о регистрационном номере компании
	 * @var ApiBusinessRegistrationID
	 */
	public $businessRegistrationID;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->generalInfo))
			$this->generalInfo = new ApiGeneralInfo($this->generalInfo);
			
		if (isset($this->account))
			$this->account = new ApiAccountInfo($this->account);
			
		if (isset($this->settings))
			$this->settings = new ApiStoreSettings($this->settings);
			
		if (isset($this->company))
			$this->company = new ApiCompany($this->company);
			
		if (isset($this->formatsAndUnits))
			$this->formatsAndUnits = new ApiFormatsAndUnits($this->formatsAndUnits);
			
		if (isset($this->languages))
			$this->languages = new ApiLanguages($this->languages);
			
		if (isset($this->taxes))
			
			for ($i=0; $i < count($this->taxes); $i++)
				if (isset($this->taxes[$i]))
					$this->taxes[$i] = new ApiTax($this->taxes[$i]);
			
		if (isset($this->zones))
			
			for ($i=0; $i < count($this->zones); $i++)
				if (isset($this->zones[$i]))
					$this->zones[$i] = new ApiZone($this->zones[$i]);
			
		if (isset($this->businessRegistrationID))
			$this->businessRegistrationID = new ApiBusinessRegistrationID($this->businessRegistrationID);
			
	}
}

class ApiGeneralInfo extends ApiDTO {
	
	/**
	 * Идентификатор магазина
	 */
	public $storeId;
	
	/**
	 * Адрес магазина
	 */
	public $storeUrl;
	
	/**
	 * StarterSite магазина.
	 * @var ApiStarterSite
	 */
	public $starterSite;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->starterSite))
			$this->starterSite = new ApiStarterSite($this->starterSite);
			
	}
}

class ApiStarterSite extends ApiDTO {
	
	/**
	 * Наш поддомен для StarterSite
	 */
	public $ecwidSubdomain;
	
	/**
	 * Кастомный домен для StarterSite
	 */
	public $customDomain;
	
	/**
	 * Сгенерированный StarterSite-адрес магазина. Если пользователем задан домен для StarterSite то возвращается он, если задан только поддомен нашего домена, то возвращать будем наш домен с поддоменом.
	 */
	public $generatedUrl;
	
	/**
	 * Адрес лого магазина
	 */
	public $storeLogoUrl;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiAccountInfo extends ApiDTO {
	
	/**
	 * Имя владельца магазина
	 */
	public $accountName;
	
	/**
	 * Никнейм владельца магазина
	 */
	public $accountNickName;
	
	/**
	 * Email владельца магазина
	 */
	public $accountEmail;
	
	/**
	 * Список фич, разрешенных в плане мерчанта
	 */
	public $availableFeatures;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiStoreSettings extends ApiDTO {
	
	/**
	 * Признак закрыт ли магазин
	 */
	public $closed;
	
	/**
	 * Название магазина
	 */
	public $storeName;
	
	/**
	 * Url лого для заказа
	 */
	public $invoiceLogoUrl;
	
	/**
	 * Url лого для почтовых нотификаций
	 */
	public $emailLogoUrl;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCompany extends ApiDTO {
	
	/**
	 * Название компании
	 */
	public $companyName;
	
	/**
	 * E-mail компании
	 */
	public $email;
	
	/**
	 * Адрес
	 */
	public $street;
	
	/**
	 * Город
	 */
	public $city;
	
	/**
	 * Код страны
	 */
	public $countryCode;
	
	/**
	 * Почтовый индекс
	 */
	public $postalCode;
	
	/**
	 * Республика/Область
	 */
	public $stateOrProvinceCode;
	
	/**
	 * Номер телефона
	 */
	public $phone;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiFormatsAndUnits extends ApiDTO {
	
	/**
	 * Валюта магазина
	 */
	public $currency;
	
	/**
	 * Префикс валюты
	 */
	public $currencyPrefix;
	
	/**
	 * Суффикс валюты
	 */
	public $currencySuffix;
	
	/**
	 * Разделитель групп разрядов для валюты
	 */
	public $currencyGroupSeparator;
	
	/**
	 * Десятичный разделитель для валюты
	 */
	public $currencyDecimalSeparator;
	
	/**
	 * Убирать ли нули после десятичного разелителя
	 */
	public $currencyTruncateZeroFractional;
	
	/**
	 * Цена выбранной валюты в долларах США
	 */
	public $currencyRate;
	
	/**
	 * Единица измерения веса используемая в магазине.
	 */
	public $weightUnit;
	
	/**
	 * Разделитель групп разрядов для веса
	 */
	public $weightGroupSeparator;
	
	/**
	 * Десятичный разделитель для веса
	 */
	public $weightDecimalSeparator;
	
	/**
	 * Убирать ли нули после десятичного разделителя
	 */
	public $weightTruncateZeroFractional;
	
	/**
	 * Формат отображения времени
	 */
	public $timeFormat;
	
	/**
	 * Формат отображения даты
	 */
	public $dateFormat;
	
	/**
	 * Таймзона
	 */
	public $timezone;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiLanguages extends ApiDTO {
	
	/**
	 * Разрешенные в сторефронте языки
	 */
	public $enabledLanguages;
	
	/**
	 * Предпочитаемый язык фейсбука
	 */
	public $facebookPreferredLocale;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiTax extends ApiDTO {
	
	/**
	 * Уникальный идентификатор налога
	 */
	public $id;
	
	/**
	 * Название налога
	 */
	public $name;
	
	/**
	 * Разрешен ли налог
	 */
	public $enabled;
	
	/**
	 * Включается ли налог в цену товара
	 */
	public $includeInPrice;
	
	/**
	 * Использовать ли для расчета налога адрес доставки
	 */
	public $useShippingAddress;
	
	/**
	 * Облагается ли налогом наряду со стоимостью товаров еще и стоимость доставки
	 */
	public $taxShipping;
	
	/**
	 * Применяется ли для всех продуктов по умолчанию
	 */
	public $appliedByDefault;
	
	/**
	 * Значение налога по умолчанию
	 */
	public $defaultTax;
	
	/**
	 * 
	 * @var ApiTaxRule[]
	 */
	public $rules;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->rules))
			
			for ($i=0; $i < count($this->rules); $i++)
				if (isset($this->rules[$i]))
					$this->rules[$i] = new ApiTaxRule($this->rules[$i]);
			
	}
}

class ApiTaxRule extends ApiDTO {
	
	/**
	 * Уникальный идентификатор зоны, для которой применяется налог
	 */
	public $zoneId;
	
	/**
	 * Значение налога для конкретной зоны
	 */
	public $tax;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiZone extends ApiDTO {
	
	/**
	 * Уникальный идентификатор зоны
	 */
	public $id;
	
	/**
	 * Название зоны
	 */
	public $name;
	
	/**
	 * Список кодов стран входящих в зону
	 */
	public $countryCodes;
	
	/**
	 * Список штатов/областей входящих в зону. Данные коды имеют вид код_страны-код_штата, например AU-NT
	 */
	public $stateOrProvinceCodes;
	
	/**
	 * Список шаблонов почтовых кодов, которые применяются для идентификации зоны. 
     * Используйте '?' и '*' в качестве универсальных заменителей. '?' заменяет любой символ, '*' заменяет любую последовательность символов (включая пустую). Пробелы игнорируются. '_' заменяет любое количество пробелов (но хотя бы один).
     * Пример:
     * 2204*
     * 38?45
     * 23*
     * 123_4??
	 */
	public $postCodes;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiBusinessRegistrationID extends ApiDTO {
	
	/**
	 * Определенное пользователем название поля
	 */
	public $name;
	
	/**
	 * Значение регистрационного номера компании
	 */
	public $value;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiLatestStats extends ApiDTO {
	
	/**
	 * Дата последнего обновления товаров
	 */
	public $productsUpdated;
	
	/**
	 * Дата последнего обновления заказов
	 */
	public $ordersUpdated;
	
	/**
	 * Дата последнего обновления настроек магазина
	 */
	public $profileUpdated;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCustomer extends ApiDTO {
	
	/**
	 * Идентификатор клиента
	 */
	public $id;
	
	/**
	 * Email клиента
	 */
	public $email;
	
	/**
	 * Пароль клиента. Прочитать его нельзя, его можно только задать.
	 */
	public $password;
	
	/**
	 * Дата регистрации клиента
	 */
	public $registered;
	
	/**
	 * Имя, введенное при регистрации, и адрес, введенный при первом заказе. Если заказов не было, то поля адреса пустые.
	 * @var ApiPerson
	 */
	public $billingPerson;
	
	/**
	 * Список адресов в адресной книге.
	 * @var ApiShippingAddress[]
	 */
	public $shippingAddresses;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->billingPerson))
			$this->billingPerson = new ApiPerson($this->billingPerson);
			
		if (isset($this->shippingAddresses))
			
			for ($i=0; $i < count($this->shippingAddresses); $i++)
				if (isset($this->shippingAddresses[$i]))
					$this->shippingAddresses[$i] = new ApiShippingAddress($this->shippingAddresses[$i]);
			
	}
}

class ApiCustomerSearchEntry extends ApiDTO {
	
	/**
	 * Идентификатор клиента
	 */
	public $id;
	
	/**
	 * Имя клиента.
	 */
	public $name;
	
	/**
	 * Email клиента
	 */
	public $email;
	
	/**
	 * Количество заказов клиента.
	 */
	public $totalOrderCount;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiShippingAddress extends ApiDTO {
	
	/**
	 * Идентификатор шиппинг адреса
	 */
	public $id;
	
	/**
	 * Имя
	 */
	public $name;
	
	/**
	 * Название фирмы
	 */
	public $companyName;
	
	/**
	 * Улица
	 */
	public $street;
	
	/**
	 * Город
	 */
	public $city;
	
	/**
	 * Код страны
	 */
	public $countryCode;
	
	/**
	 * Почтовый индекс
	 */
	public $postalCode;
	
	/**
	 * Код штата
	 */
	public $stateOrProvinceCode;
	
	/**
	 * Номер телефона
	 */
	public $phone;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiDeletedProductsResponse extends ApiDTO {
	
	/**
	 * Общее количество записей, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество записей в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество записей возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных Id
	 * @var ApiDeletedProductTO[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiDeletedProductTO($this->items[$i]);
			
	}
}

class ApiDeletedCustomersResponse extends ApiDTO {
	
	/**
	 * Общее количество записей, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество записей в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество записей возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных Id
	 * @var ApiDeletedCustomerTO[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiDeletedCustomerTO($this->items[$i]);
			
	}
}

class ApiDeletedOrdersResponse extends ApiDTO {
	
	/**
	 * Общее количество записей, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество записей в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество записей возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных Id
	 * @var ApiDeletedOrderTO[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiDeletedOrderTO($this->items[$i]);
			
	}
}

class ApiDeletedDiscountCouponsResponse extends ApiDTO {
	
	/**
	 * Общее количество записей, удовлетворяющих критериям поиска
	 */
	public $total;
	
	/**
	 * Количество записей в списке
	 */
	public $count;
	
	/**
	 * Смещение от начала списка
	 */
	public $offset;
	
	/**
	 * Максимальное количество записей возвращаемых в выборке
	 */
	public $limit;
	
	/**
	 * Список найденных Id
	 * @var ApiDeletedDiscountCouponTO[]
	 */
	public $items;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
		if (isset($this->items))
			
			for ($i=0; $i < count($this->items); $i++)
				if (isset($this->items[$i]))
					$this->items[$i] = new ApiDeletedDiscountCouponTO($this->items[$i]);
			
	}
}

class ApiDeletedCustomerTO extends ApiDTO {
	
	/**
	 * 
	 */
	public $id;
	
	/**
	 * 
	 */
	public $date;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiCreateCouponStatus extends ApiDTO {
	
	/**
	 * Идентификатор созданного купона
	 */
	public $code;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiDeletedProductTO extends ApiDTO {
	
	/**
	 * 
	 */
	public $id;
	
	/**
	 * 
	 */
	public $date;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiDeletedOrderTO extends ApiDTO {
	
	/**
	 * 
	 */
	public $id;
	
	/**
	 * 
	 */
	public $date;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class ApiDeletedDiscountCouponTO extends ApiDTO {
	
	/**
	 * 
	 */
	public $code;
	
	/**
	 * 
	 */
	public $date;
	

	public function __construct($json = null) {
		parent::__construct($json);
	
	}
}

class _ApiProductsDeletedEntityService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeletedProductsResponse
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeletedProductsResponse(json_decode($response->data));
			
	}
}

class _ApiCustomersDeletedEntityService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeletedCustomersResponse
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeletedCustomersResponse(json_decode($response->data));
			
	}
}

class _ApiDiscountCouponsDeletedEntityService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeletedDiscountCouponsResponse
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeletedDiscountCouponsResponse(json_decode($response->data));
			
	}
}

class _ApiOrdersDeletedEntityService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeletedOrdersResponse
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeletedOrdersResponse(json_decode($response->data));
			
	}
}

class _ApiListDiscountCouponService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDiscountCouponResult
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDiscountCouponResult(json_decode($response->data));
			
	}
}

class _ApiGetDiscountCouponService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDiscountCoupon
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDiscountCoupon(json_decode($response->data));
			
	}
}

class _ApiDeleteDiscountCouponService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}


class _ApiUpdateDiscountCouponService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiCreateDiscountCouponService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateCouponStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateCouponStatus(json_decode($response->data));
			
	}
}

class _ApiGetProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiProduct
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiProduct(json_decode($response->data));
			
	}
}

class _ApiSearchProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiProductSearchResult
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiProductSearchResult(json_decode($response->data));
			
	}
}

class _ApiCreateProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUploadProductImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiUploadProductFileApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiGetProductEgoodApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected binary output.");
				return $response->data;
			
	}
}

class _ApiUploadProductGalleryImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteProductGalleryImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiClearProductGalleryApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteProductImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteProductFileApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiClearProductFilesApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteCategoryImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUploadCategoryImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiUploadCombinationImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteCombinationImageApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUploadOrderItemOptionFileApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteOrderItemOptionFileApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiClearOrderItemOptionFilesApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUploadProfileLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiUploadInvoiceLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiUploadEmailLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUploadStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUploadStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteProfileLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteInvoiceLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteEmailLogoApiUploadService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiGetCombinationsProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCombination[]
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON array.");
		$result = array();
		foreach (json_decode($response->data) as $json) {
			$result[] = new ApiCombination($json);
		}
		return $result;
	}
}

class _ApiGetCombinationProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCombination
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCombination(json_decode($response->data));
			
	}
}

class _ApiCreateCombinationProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateCombinationProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiClearCombinationsProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteCombinationProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiGetCategoryService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCategory
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCategory(json_decode($response->data));
			
	}
}

class _ApiListCategoryService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCategorySearchResult
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCategorySearchResult(json_decode($response->data));
			
	}
}

class _ApiCreateCategoryService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiDeleteCategoryService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateCategoryService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiListClassesProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiProductClass[]
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON array.");
		$result = array();
		foreach (json_decode($response->data) as $json) {
			$result[] = new ApiProductClass($json);
		}
		return $result;
	}
}

class _ApiGetClassByIdProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiProductClass
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiProductClass(json_decode($response->data));
			
	}
}

class _ApiRemoveClassByIdProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateProductClassProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiCreateProductClassProductApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiGetOrdersOrderApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiOrderSearchResult
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiOrderSearchResult(json_decode($response->data));
			
	}
}

class _ApiGetOrderOrderApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiOrder
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiOrder(json_decode($response->data));
			
	}
}

class _ApiCreateOrderOrderApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateOrderOrderApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiRemoveOrderOrderApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiGetProfileApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiProfile
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiProfile(json_decode($response->data));
			
	}
}

class _ApiUpdateProfileApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _ApiGetStatsApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiLatestStats
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiLatestStats(json_decode($response->data));
			
	}
}

class _ApiGetCustomerApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCustomer
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCustomer(json_decode($response->data));
			
	}
}

class _ApiSearchCustomerApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCustomerSearchResult
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "GET", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCustomerSearchResult(json_decode($response->data));
			
	}
}

class _ApiDeleteCustomerApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiDeleteStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "DELETE", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiDeleteStatus(json_decode($response->data));
			
	}
}

class _ApiCreateCustomerApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiCreateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "POST", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiCreateStatus(json_decode($response->data));
			
	}
}

class _ApiUpdateCustomerApiService extends ApiRequest {
	/**
	 * Make the HTTP request and return the result.
	 * @return ApiUpdateStatus
	 */
	public function execute()
	{
		$executor = $this->executor;
		$response = $executor($this->url, "PUT", $this->body);
		if (!$response->data) throw new EmptyBodyException("No response. Expected JSON object.");
				return new ApiUpdateStatus(json_decode($response->data));
			
	}
}

class _UriBuilder {
	private $_url;
	private $_params;

	public function __construct($url) {
		$this->_url = $url;
	}

	public function setParameter($name, $value) {
		if (!isset($this->_params)) $this->_params = array();
		$this->_params[$name] = $value;
	}

	public function build() {
		if (isset($this->_params)) {
			$url = $this->_url . "?";
			$first = TRUE;
			foreach ($this->_params as $name => $value) {
				if ($first) $first = FALSE;
				else $url .= "&";
				$url .= "$name=".rawurlencode($value);
			}
			return $url;
		}
		return $this->_url;
	}
}

class ApiClient {
	
	/**
	 * A function with signature ($url, $method, $body, $headers) that executes an HTTP
	 * request.
	 */
	public $executor;

	/**
	 * The API endpoint URL. The default is "use the url parameter to set default endpoint url, and an optional https-url to set the https url.".
	 */
	public $url = ECWID_APIV3_URL;



	public function __construct($ch = null) {
		if ($ch == null) {
			$ch = curl_init();
			#curl_setopt($this->ch, CURLOPT_FORBID_REUSE, 1); 
			#curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, 1);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$this->ch = $ch;
		$client = $this;
		$this->executor = function($url, $method, HttpEntity $body = null, array $headers = null) use($client) {
			$ch = $client->ch;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			if ($body != null) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $body->body);
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, "");
			}
			if ($headers == null) $headers = array();
			if ($body != null && $body->contentType) $headers[] = "Content-Type: ".$body->contentType;
			$headers[] = "Expect:";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			if( ! $response = curl_exec($ch))
			{ 
				trigger_error(curl_error($ch)); 
			}
			$info = curl_getinfo($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headersString = substr($response, 0, $header_size);
			$data = substr($response, $header_size);
			if ($info['http_code'] >= 400) {
				$matches = array();
				preg_match('/HTTP[^ ]+ +[0-9]+ +(.*)/', $headersString, $matches);
				throw new StatusException($matches[1], $info['http_code']);
			}
			$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
			$headers = array();
			foreach (preg_split("/[\\n\\r]/", $headersString) as $headerLine) {
				$pos = strpos($headerLine, ':');
				if ($pos !== false) {
					$headers[trim(substr($headerLine, 0, $pos))] = trim(substr($headerLine, $pos+1));
				}
			}
			return new ApiResponse($data, $contentType, $headers);
		};
	}


	/**
	 * Builds Request object for the "Получить удаленные продукты" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * 
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param from_date string начальная дата с которой делать выборку
	 * @param to_date string максимальная дата с которой делать выборку
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет,
     * отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество элементов возвращаемых в выборке. Должно быть больше 0.
     * Максимальное значение 1000. По умолчанию значение 100.
	 * @return _ApiProductsDeletedEntityService
	 */
	public function productsDeletedEntityService( $storeId, $token, $from_date, $to_date, $offset, $limit) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/deleted");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($from_date != null) $builder->setParameter("from_date",
			$from_date);
		if ($to_date != null) $builder->setParameter("to_date",
			$to_date);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiProductsDeletedEntityService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Получить удаленных покупателей" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * 
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param from_date string начальная дата с которой делать выборку
	 * @param to_date string максимальная дата с которой делать выборку
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет,
     * отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество элементов возвращаемых в выборке. Должно быть больше 0.
     * Максимальное значение 1000. По умолчанию значение 100.
	 * @return _ApiCustomersDeletedEntityService
	 */
	public function customersDeletedEntityService( $storeId, $token, $from_date, $to_date, $offset, $limit) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers/deleted");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($from_date != null) $builder->setParameter("from_date",
			$from_date);
		if ($to_date != null) $builder->setParameter("to_date",
			$to_date);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiCustomersDeletedEntityService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Получить удаленные купоны" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * 
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param from_date string начальная дата с которой делать выборку
	 * @param to_date string максимальная дата с которой делать выборку
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет,
     * отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество элементов возвращаемых в выборке. Должно быть больше 0.
     * Максимальное значение 1000. По умолчанию значение 100.
	 * @return _ApiDiscountCouponsDeletedEntityService
	 */
	public function discountCouponsDeletedEntityService( $storeId, $token, $from_date, $to_date, $offset, $limit) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons/deleted");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($from_date != null) $builder->setParameter("from_date",
			$from_date);
		if ($to_date != null) $builder->setParameter("to_date",
			$to_date);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiDiscountCouponsDeletedEntityService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Получить удаленные заказы" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * 
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param from_date string начальная дата с которой делать выборку
	 * @param to_date string максимальная дата с которой делать выборку
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет,
     * отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество элементов возвращаемых в выборке. Должно быть больше 0.
     * Максимальное значение 1000. По умолчанию значение 100.
	 * @return _ApiOrdersDeletedEntityService
	 */
	public function ordersDeletedEntityService( $storeId, $token, $from_date, $to_date, $offset, $limit) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/deleted");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($from_date != null) $builder->setParameter("from_date",
			$from_date);
		if ($to_date != null) $builder->setParameter("to_date",
			$to_date);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiOrdersDeletedEntityService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get discount coupons" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение списка купов магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param code string Уникальный код купона
	 * @param discount_type string Comma separated list of discount types e.g. discountType=ABS,PERCENT
	 * @param availability string Comma separated list of availability statuses e.g. availability=ACTIVE,EXPIRED
	 * @param limit number Количество записей возвращаемых в результатах запроса
	 * @param offset number Смещение в результирующей выборке
	 * @return _ApiListDiscountCouponService
	 */
	public function listDiscountCouponService( $storeId, $token, $code, $discount_type, $availability, $limit, $offset) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($code != null) $builder->setParameter("code",
			$code);
		if ($discount_type != null) $builder->setParameter("discount_type",
			$discount_type);
		if ($availability != null) $builder->setParameter("availability",
			$availability);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiListDiscountCouponService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a discount coupon" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Get discount coupon by code
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param code string Уникальный код купона
	 * @return _ApiGetDiscountCouponService
	 */
	public function getDiscountCouponService( $storeId, $token, $code) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons/".$code);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($code == null) throw new IllegalArgumentException("No parameter code is set");
		
		return new _ApiGetDiscountCouponService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete discount coupons" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление купонов
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param code string Уникальный код купона
	 * @param discount_type string Comma separated list of discount types e.g. discountType=ABS,PERCENT
	 * @param availability string Comma separated list of availability statuses e.g. availability=ACTIVE,EXPIRED
	 * @return _ApiDeleteDiscountCouponService
	 */
	public function deleteDiscountCouponService( $storeId, $token, $code, $discount_type, $availability) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($code != null) $builder->setParameter("code",
			$code);
		if ($discount_type != null) $builder->setParameter("discount_type",
			$discount_type);
		if ($availability != null) $builder->setParameter("availability",
			$availability);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiDeleteDiscountCouponService($this->executor, $builder->build()
		);
	}


	/**
	 * Builds Request object for the "Update a discount coupon" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Изменение купона
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param code string Уникальный код купона
	 * @param body ApiDiscountCoupon 
	 * @return _ApiUpdateDiscountCouponService
	 */
	public function updateDiscountCouponService( $storeId, $token, $code,ApiDiscountCoupon $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons/".$code);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($code == null) throw new IllegalArgumentException("No parameter code is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateDiscountCouponService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Create a discount coupon" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Создание купона
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiDiscountCoupon 
	 * @return _ApiCreateDiscountCouponService
	 */
	public function createDiscountCouponService( $storeId, $token,ApiDiscountCoupon $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/discount_coupons");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateDiscountCouponService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Get a product" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Get a product
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param productId number Идентификатор запрашиваемого продукта
	 * @return _ApiGetProductApiService
	 */
	public function getProductApiService( $storeId, $token, $productId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$productId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($productId == null) throw new IllegalArgumentException("No parameter productId is set");
		
		return new _ApiGetProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Search products" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Поиск продуктов по различным параметрам.(Поиск ведется в нашем продуктовом солре)
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param keyword string Слово, которое будем искать в названии продукта, его артикуле, описании, а также в опциях
	 * @param priceFrom number Минимальная цена товара
	 * @param priceTo number Максимальная цена товара
	 * @param category number Идентификатор категории, чьи продукты необходимо найти
	 * @param withSubcategories boolean Если true, в выборку будут включены продукты из подкатегорий категории. Если параметр category не указан, то данный параметр не оказывает никакого эффекта
	 * @param sortBy string Порядок сортировки продуктов. Допустимые значения:
     * RELEVANCE - сортировка по релевантности;
     * ADDED_TIME_ASC - сортировка по дате добавления(от давно добавленных, к недавно добавленным);
     * ADDED_TIME_DESC - сортировка по дате добавления(от недавно добавленных, к давно добавленным);
     * NAME_ASC - сортировка по имени продукта(в алфавитном порядке);
     * NAME_DESC - сортировка по имени продукта(в обратном алфавитном порядке);
     * PRICE_ASC - сортировка по цене(от меньшей к большей);
     * PRICE_DESC - сортировка по цене(от большей к меньшей).
     * Значение по дефолту - RELEVANCE
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет, отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество продуктов возвращаемых в выборке. Должно быть больше 0. Максимальное значение 100. По умолчанию значение 10.
	 * @param createdFrom string Самая ранняя дата создания товара
	 * @param createdTo string Самая поздняя дата создания товара
	 * @param updatedFrom string Самая ранняя дата обновления товара
	 * @param updatedTo string Самая поздняя дата обновления товара
	 * @param enabled boolean Разрешен ли товар
	 * @param inStock boolean Есть ли товар в наличии
	 * @return _ApiSearchProductApiService
	 */
	public function searchProductApiService( $storeId, $token, $keyword, $priceFrom, $priceTo, $category, $withSubcategories, $sortBy, $offset, $limit, $createdFrom, $createdTo, $updatedFrom, $updatedTo, $enabled, $inStock) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($keyword != null) $builder->setParameter("keyword",
			$keyword);
		if ($priceFrom != null) $builder->setParameter("priceFrom",
			$priceFrom);
		if ($priceTo != null) $builder->setParameter("priceTo",
			$priceTo);
		if ($category != null) $builder->setParameter("category",
			$category);
		if ($withSubcategories != null) $builder->setParameter("withSubcategories",
			self::boolean_param($withSubcategories));
		if ($sortBy != null) $builder->setParameter("sortBy",
			$sortBy);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		if ($createdFrom != null) $builder->setParameter("createdFrom",
			$createdFrom);
		if ($createdTo != null) $builder->setParameter("createdTo",
			$createdTo);
		if ($updatedFrom != null) $builder->setParameter("updatedFrom",
			$updatedFrom);
		if ($updatedTo != null) $builder->setParameter("updatedTo",
			$updatedTo);
		if ($enabled != null) $builder->setParameter("enabled",
			self::boolean_param($enabled));
		if ($inStock != null) $builder->setParameter("inStock",
			self::boolean_param($inStock));
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiSearchProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Add a product" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Add a product
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiProduct 
	 * @return _ApiCreateProductApiService
	 */
	public function createProductApiService( $storeId, $token,ApiProduct $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Update a product" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Update a product
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param productId number Идентификатор изменяемого продукта
	 * @param body ApiProduct 
	 * @return _ApiUpdateProductApiService
	 */
	public function updateProductApiService( $storeId, $token, $productId,ApiProduct $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$productId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($productId == null) throw new IllegalArgumentException("No parameter productId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Delete a product" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Delete a product
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param productId number Идентификатор удаляемого продукта
	 * @return _ApiDeleteProductApiService
	 */
	public function deleteProductApiService( $storeId, $token, $productId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$productId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($productId == null) throw new IllegalArgumentException("No parameter productId is set");
		
		return new _ApiDeleteProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Upload product image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка на сервер картинки товара
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, картинка которого будет загружена
	 * @param body string 
	 * @return _ApiUploadProductImageApiUploadService
	 */
	public function uploadProductImageApiUploadService( $storeId, $token, $id, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadProductImageApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Upload product file" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка на сервер egoods продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатора продукта для которого заливаем egood
	 * @param fileName string Название заливаемого egood-файла
	 * @param description string Короткое описание заливаемого egood-файла
	 * @param body string 
	 * @return _ApiUploadProductFileApiUploadService
	 */
	public function uploadProductFileApiUploadService( $storeId, $token, $id, $fileName, $description, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/files");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($description != null) $builder->setParameter("description",
			$description);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($fileName == null) throw new IllegalArgumentException("No parameter fileName is set");
		$builder->setParameter("fileName", $fileName);
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadProductFileApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Get product egood" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение файла продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, egood которого запрашиваем
	 * @param fileId number Идентификатор egood
	 * @return _ApiGetProductEgoodApiUploadService
	 */
	public function getProductEgoodApiUploadService( $storeId, $token, $id, $fileId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/files/".$fileId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($fileId == null) throw new IllegalArgumentException("No parameter fileId is set");
		
		return new _ApiGetProductEgoodApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Upload gallery image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка картинки галереи на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param fileName string Имя файла картинки загружаемой в галерею продукта
	 * @param id number Идентификатор продукта, для которого загружаем картинку в галерею
	 * @param body string 
	 * @return _ApiUploadProductGalleryImageApiUploadService
	 */
	public function uploadProductGalleryImageApiUploadService( $storeId, $token, $fileName, $id, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/gallery");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($fileName != null) $builder->setParameter("fileName",
			$fileName);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadProductGalleryImageApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Delete a product gallery image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление картинки из галереи продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, у которого удаляем картинку из галереи
	 * @param fileId number Идентификатор картинки, удаляемой из галереи продукта
	 * @return _ApiDeleteProductGalleryImageApiUploadService
	 */
	public function deleteProductGalleryImageApiUploadService( $storeId, $token, $id, $fileId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/gallery/".$fileId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($fileId == null) throw new IllegalArgumentException("No parameter fileId is set");
		
		return new _ApiDeleteProductGalleryImageApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Clear product gallery" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление всех картинок из галереи продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, у которого удаляем все картинки из галереи
	 * @return _ApiClearProductGalleryApiUploadService
	 */
	public function clearProductGalleryApiUploadService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/gallery");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiClearProductGalleryApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete product image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление картинки продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, чью картинку удаляем
	 * @return _ApiDeleteProductImageApiUploadService
	 */
	public function deleteProductImageApiUploadService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiDeleteProductImageApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete product egood" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление egood продукта по айдишнику этого egood
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, чей egood удаляем
	 * @param fileId number Идентификатор файла, который нужно удалить
	 * @return _ApiDeleteProductFileApiUploadService
	 */
	public function deleteProductFileApiUploadService( $storeId, $token, $id, $fileId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/files/".$fileId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($fileId == null) throw new IllegalArgumentException("No parameter fileId is set");
		
		return new _ApiDeleteProductFileApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Clear product egoods" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление всех egoods продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, у которого нужно удалить все egoods
	 * @return _ApiClearProductFilesApiUploadService
	 */
	public function clearProductFilesApiUploadService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/files");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiClearProductFilesApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete category image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление картинки категории
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор категории, у которой удаляем картинку
	 * @return _ApiDeleteCategoryImageApiUploadService
	 */
	public function deleteCategoryImageApiUploadService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories/".$id."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiDeleteCategoryImageApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Upload category image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка картинки категории на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор категории, для которой загружаем картинку
	 * @param body string 
	 * @return _ApiUploadCategoryImageApiUploadService
	 */
	public function uploadCategoryImageApiUploadService( $storeId, $token, $id, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories/".$id."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadCategoryImageApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Upload a product combination image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка картинки продуктовой комбинации на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, для комбинации которого заливается картинка
	 * @param combinationId number Идентификатор комбинации, для которой заливается картинка
	 * @param body string 
	 * @return _ApiUploadCombinationImageApiUploadService
	 */
	public function uploadCombinationImageApiUploadService( $storeId, $token, $id, $combinationId, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations/".$combinationId."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($combinationId == null) throw new IllegalArgumentException("No parameter combinationId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadCombinationImageApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Delete a product combination image" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление картинки продуктовой комбинации
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, у комбинации которого удаляется картинка
	 * @param combinationId number Идентификатор продуктовой комбинации, у которой удаляется картинка
	 * @return _ApiDeleteCombinationImageApiUploadService
	 */
	public function deleteCombinationImageApiUploadService( $storeId, $token, $id, $combinationId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations/".$combinationId."/image");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($combinationId == null) throw new IllegalArgumentException("No parameter combinationId is set");
		
		return new _ApiDeleteCombinationImageApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Upload a order item option file" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка файла для продуктовой опции в ордер айтеме
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Номер ордера, для айтема которого нужно залить файл-значение продуктовой опции
	 * @param itemId number Идентификатор айтема для ордера, для которого нужно залить файл-значение продуктовой опции
	 * @param optionName string Название опции, для которой заливается картинка
	 * @param fileName string Имя файла загружаемого в продуктовую опцию
	 * @param body string 
	 * @return _ApiUploadOrderItemOptionFileApiUploadService
	 */
	public function uploadOrderItemOptionFileApiUploadService( $storeId, $token, $orderNumber, $itemId, $optionName, $fileName, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber."/items/".$itemId."/options/".$optionName);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		if ($itemId == null) throw new IllegalArgumentException("No parameter itemId is set");
		
		if ($optionName == null) throw new IllegalArgumentException("No parameter optionName is set");
		
		if ($fileName == null) throw new IllegalArgumentException("No parameter fileName is set");
		$builder->setParameter("fileName", $fileName);
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadOrderItemOptionFileApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Delete a order item option file" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление файла для продуктовой опции в ордер айтеме
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Номер ордера, для айтема которого нужно удалить файл-значение продуктовой опции
	 * @param itemId number Идентификатор айтема для ордера, для которого нужно удалить файл-значение продуктовой опции
	 * @param optionName string Название опции, для которой удаляется файл
	 * @param fileId number Идентификатор файла, который нужно удалить
	 * @return _ApiDeleteOrderItemOptionFileApiUploadService
	 */
	public function deleteOrderItemOptionFileApiUploadService( $storeId, $token, $orderNumber, $itemId, $optionName, $fileId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber."/items/".$itemId."/options/".$optionName."/files/".$fileId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		if ($itemId == null) throw new IllegalArgumentException("No parameter itemId is set");
		
		if ($optionName == null) throw new IllegalArgumentException("No parameter optionName is set");
		
		if ($fileId == null) throw new IllegalArgumentException("No parameter fileId is set");
		
		return new _ApiDeleteOrderItemOptionFileApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete all order item option files" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление всех файлов для продуктовой опции в ордер айтеме
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Номер ордера, для айтема которого нужно удалить файлы-значения продуктовой опции
	 * @param itemId number Идентификатор айтема для ордера, для которого нужно удалить файлы-значения продуктовой опции
	 * @param optionName string Название опции, для которой удаляются файлы
	 * @return _ApiClearOrderItemOptionFilesApiUploadService
	 */
	public function clearOrderItemOptionFilesApiUploadService( $storeId, $token, $orderNumber, $itemId, $optionName) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber."/items/".$itemId."/options/".$optionName."/files");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		if ($itemId == null) throw new IllegalArgumentException("No parameter itemId is set");
		
		if ($optionName == null) throw new IllegalArgumentException("No parameter optionName is set");
		
		return new _ApiClearOrderItemOptionFilesApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Upload a store logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка логотипа магазина на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body string 
	 * @return _ApiUploadProfileLogoApiUploadService
	 */
	public function uploadProfileLogoApiUploadService( $storeId, $token, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/logo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadProfileLogoApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Upload a store invoice logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка логотипа для инвойса магазина на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body string 
	 * @return _ApiUploadInvoiceLogoApiUploadService
	 */
	public function uploadInvoiceLogoApiUploadService( $storeId, $token, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/invoicelogo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadInvoiceLogoApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Upload a store email logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Загрузка логотипа для почтовых нотификаций на сервер
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body string 
	 * @return _ApiUploadEmailLogoApiUploadService
	 */
	public function uploadEmailLogoApiUploadService( $storeId, $token, $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/emaillogo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUploadEmailLogoApiUploadService($this->executor, $builder->build()
		, new HttpEntity($body, HttpEntity::TEXT));
	}

	/**
	 * Builds Request object for the "Delete a profile logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление лого магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiDeleteProfileLogoApiUploadService
	 */
	public function deleteProfileLogoApiUploadService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/logo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiDeleteProfileLogoApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete a profile invoice logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление инвойс лого магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiDeleteInvoiceLogoApiUploadService
	 */
	public function deleteInvoiceLogoApiUploadService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/invoicelogo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiDeleteInvoiceLogoApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete a profile email logo" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление лого для нотификаций из магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiDeleteEmailLogoApiUploadService
	 */
	public function deleteEmailLogoApiUploadService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile/emaillogo");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiDeleteEmailLogoApiUploadService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get product combinations" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение всех комбинаций продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, комбинации которого нужно получить
	 * @return _ApiGetCombinationsProductApiService
	 */
	public function getCombinationsProductApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiGetCombinationsProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a product combination" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение продуктовой комбинации по ее айдишнику
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, комбинацию которого мы хотим получить
	 * @param combinationId number Идентификатор комбинации, которую мы хотим получить
	 * @return _ApiGetCombinationProductApiService
	 */
	public function getCombinationProductApiService( $storeId, $token, $id, $combinationId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations/".$combinationId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($combinationId == null) throw new IllegalArgumentException("No parameter combinationId is set");
		
		return new _ApiGetCombinationProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Create a product combination" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Создание продуктовой комбинации
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, которому мы добавляем комбинацию
	 * @param body ApiCombination 
	 * @return _ApiCreateCombinationProductApiService
	 */
	public function createCombinationProductApiService( $storeId, $token, $id,ApiCombination $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateCombinationProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Update a product combination" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Изменение продуктовой комбинации
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, комбинация которого изменяется
	 * @param combinationId number Идентификатор комбинации, которая изменяется
	 * @param body ApiCombination 
	 * @return _ApiUpdateCombinationProductApiService
	 */
	public function updateCombinationProductApiService( $storeId, $token, $id, $combinationId,ApiCombination $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations/".$combinationId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($combinationId == null) throw new IllegalArgumentException("No parameter combinationId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateCombinationProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Delete product combinations" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление всех продуктовых комбинаций продукта
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, комбинации которого нужно удалить
	 * @return _ApiClearCombinationsProductApiService
	 */
	public function clearCombinationsProductApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiClearCombinationsProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete a product combination" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление продуктовой комбинации
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продукта, чью комбинацию нужно удалить
	 * @param combinationId number Идентификатор комбинации, которую нужно удалить
	 * @return _ApiDeleteCombinationProductApiService
	 */
	public function deleteCombinationProductApiService( $storeId, $token, $id, $combinationId) {
		$builder = new _UriBuilder($this->url."/".$storeId."/products/".$id."/combinations/".$combinationId);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($combinationId == null) throw new IllegalArgumentException("No parameter combinationId is set");
		
		return new _ApiDeleteCombinationProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a category" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Returns a single category with the given id. Disabled categories are not returned, unless queried with authentication.
	 * @param storeId number ID of the Ecwid store.
	 * @param id number Уникальный идентификатор категории
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiGetCategoryService
	 */
	public function getCategoryService( $storeId, $id, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiGetCategoryService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get categories" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Returns an array of immediate subcategories of a given parent category. If the parent parameter is absent, returns all categories. If parent=0, returns a list of root categories. Disabled categories are not returned, but enabled subcategories of disabled categories are.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param parent number Идентификатор категории-родителя, чьих детей надо получить
	 * @param hidden_categories boolean Флаг указывающий на то, нужно ли возвращать в выдаче кроме разрешенных категорий еще и запрещенные
	 * @param productIds boolean Показывать ли для категорий список идентификаторов продуктов, принадлежащих им
	 * @param limit number Количество записей возвращаемых в результатах запроса
	 * @param offset number Смещение в результирующей выборке
	 * @return _ApiListCategoryService
	 */
	public function listCategoryService( $storeId, $token, $parent, $hidden_categories, $productIds, $limit, $offset) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($parent != null) $builder->setParameter("parent",
			$parent);
		if ($hidden_categories != null) $builder->setParameter("hidden_categories",
			self::boolean_param($hidden_categories));
		if ($productIds != null) $builder->setParameter("productIds",
			self::boolean_param($productIds));
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiListCategoryService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Create a category" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Adds a category to a store under the specified subcategory (parentId) or as a root category (when
     * parentId=0).
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiCategory 
	 * @return _ApiCreateCategoryService
	 */
	public function createCategoryService( $storeId, $token,ApiCategory $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateCategoryService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Delete a category" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Deletes a category with the given
     * <code>id</code>
     * and its subcategories. No products are removed.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор категории, которую нужно удалить
	 * @return _ApiDeleteCategoryService
	 */
	public function deleteCategoryService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiDeleteCategoryService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Change a category" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Changes a category identified with <code>id</code>. To reorder categories, change their orderBy.
     * To move a category to another parent category, change its parentId.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Id of the category to change.
	 * @param body ApiCategory 
	 * @return _ApiUpdateCategoryService
	 */
	public function updateCategoryService( $storeId, $token, $id,ApiCategory $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/categories/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateCategoryService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Get product classes" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * List all product classes in a store.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiListClassesProductApiService
	 */
	public function listClassesProductApiService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/classes");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiListClassesProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a product class" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Return information about a single product class.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продуктового класса, который нужно получить
	 * @return _ApiGetClassByIdProductApiService
	 */
	public function getClassByIdProductApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/classes/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiGetClassByIdProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete a product class" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Remove a product class (product type) from the store. Does not remove any products. Products of this class move to the default 'General' class.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор продуктового класса, который нужно удалить
	 * @return _ApiRemoveClassByIdProductApiService
	 */
	public function removeClassByIdProductApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/classes/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiRemoveClassByIdProductApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Update a product class" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Changes an existing product class (product type) to the store. Returns the ProductClass including its attributes object with the 'id' field filled in.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор обновляемого продуктового класса
	 * @param body ApiProductClass 
	 * @return _ApiUpdateProductClassProductApiService
	 */
	public function updateProductClassProductApiService( $storeId, $token, $id,ApiProductClass $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/classes/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateProductClassProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Create a product class" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Adds new product class (product type) to the store. Returns the ProductClass including its attributes object with the 'id' field filled in.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiProductClass 
	 * @return _ApiCreateProductClassProductApiService
	 */
	public function createProductClassProductApiService( $storeId, $token,ApiProductClass $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/classes");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateProductClassProductApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Get orders list" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Return orders list for given store id.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param limit number Количество записей возвращаемых в результатах запроса
	 * @param offset number Смещение в результирующей выборке
	 * @param couponCode string Идентификатор купона примененного к заказу
	 * @param orderNumber number Номер заказа
	 * @param totalFrom number Начиная с какого тотала нужно выбирать заказы
	 * @param totalTo number Верхняя граница тотала, до которой нужно выбирать заказы
	 * @param customer string Поиск заказа по имени заказчика
	 * @param createdFrom string Нижняя граница даты создания заказа
	 * @param createdTo string Верхняя граница даты создания заказа
	 * @param paymentMethod string Выборка заказов по методу их оплаты
	 * @param vendorNumber string Выборка заказов по кастомному номеру заказа
	 * @param shippingMethod string Выборка заказов по методу их доставки
	 * @param keywords string Выборка заказов по ключевым словам найденным в заказе
	 * @param fulfillmentStatus string Статус выполнения заказа. Может передаваться как одно, так и список значений разделенных запятыми.
     * Допустимые значения: NEW, PROCESSING, SHIPPED, DELIVERED, WILL_NOT_DELIVER
	 * @param paymentStatus string Статус оплаты заказа. Может передаваться как одно так и список значений разделенных запятыми.
     * Допустимые значения: INCOMPLETE, PAID, DECLINED, CANCELLED, AWAITING_PAYMENT, CHARGEABLE
	 * @param updatedFrom string Нижняя граница даты обновления заказа
	 * @param updatedTo string Верхняя граница даты обновления заказа
	 * @return _ApiGetOrdersOrderApiService
	 */
	public function getOrdersOrderApiService( $storeId, $token, $limit, $offset, $couponCode, $orderNumber, $totalFrom, $totalTo, $customer, $createdFrom, $createdTo, $paymentMethod, $vendorNumber, $shippingMethod, $keywords, $fulfillmentStatus, $paymentStatus, $updatedFrom, $updatedTo) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($couponCode != null) $builder->setParameter("couponCode",
			$couponCode);
		if ($orderNumber != null) $builder->setParameter("orderNumber",
			$orderNumber);
		if ($totalFrom != null) $builder->setParameter("totalFrom",
			$totalFrom);
		if ($totalTo != null) $builder->setParameter("totalTo",
			$totalTo);
		if ($customer != null) $builder->setParameter("customer",
			$customer);
		if ($createdFrom != null) $builder->setParameter("createdFrom",
			$createdFrom);
		if ($createdTo != null) $builder->setParameter("createdTo",
			$createdTo);
		if ($paymentMethod != null) $builder->setParameter("paymentMethod",
			$paymentMethod);
		if ($vendorNumber != null) $builder->setParameter("vendorNumber",
			$vendorNumber);
		if ($shippingMethod != null) $builder->setParameter("shippingMethod",
			$shippingMethod);
		if ($keywords != null) $builder->setParameter("keywords",
			$keywords);
		if ($fulfillmentStatus != null) $builder->setParameter("fulfillmentStatus",
			$fulfillmentStatus);
		if ($paymentStatus != null) $builder->setParameter("paymentStatus",
			$paymentStatus);
		if ($updatedFrom != null) $builder->setParameter("updatedFrom",
			$updatedFrom);
		if ($updatedTo != null) $builder->setParameter("updatedTo",
			$updatedTo);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiGetOrdersOrderApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a order" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получить заказ по его номеру
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Идентификатор запрашиваемого ордера
	 * @return _ApiGetOrderOrderApiService
	 */
	public function getOrderOrderApiService( $storeId, $token, $orderNumber) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		return new _ApiGetOrderOrderApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Create a order" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Создание заказа в магазине
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiOrder 
	 * @return _ApiCreateOrderOrderApiService
	 */
	public function createOrderOrderApiService( $storeId, $token,ApiOrder $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateOrderOrderApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Update a order" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Изменение заказа в магазине
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Номер обновляемого заказа
	 * @param body ApiOrder 
	 * @return _ApiUpdateOrderOrderApiService
	 */
	public function updateOrderOrderApiService( $storeId, $token, $orderNumber,ApiOrder $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateOrderOrderApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Delete a order" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление заказа по его номеру
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param orderNumber number Номер заказа, который нужно удалить
	 * @return _ApiRemoveOrderOrderApiService
	 */
	public function removeOrderOrderApiService( $storeId, $token, $orderNumber) {
		$builder = new _UriBuilder($this->url."/".$storeId."/orders/".$orderNumber);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($orderNumber == null) throw new IllegalArgumentException("No parameter orderNumber is set");
		
		return new _ApiRemoveOrderOrderApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a store profile" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение профиля магазина.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiGetProfileApiService
	 */
	public function getProfileApiService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiGetProfileApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Update a store profile" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Редактирование профиля магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiProfile 
	 * @return _ApiUpdateProfileApiService
	 */
	public function updateProfileApiService( $storeId, $token,ApiProfile $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/profile");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateProfileApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Get a store stats" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение данных о последнем обновлении товаров/ордеров/профиля магазина.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @return _ApiGetStatsApiService
	 */
	public function getStatsApiService( $storeId, $token) {
		$builder = new _UriBuilder($this->url."/".$storeId."/latest-stats");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiGetStatsApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Get a customer" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Получение данных о последнем обновлении товаров/ордеров/профиля магазина.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор запрашиваемого кастомера
	 * @return _ApiGetCustomerApiService
	 */
	public function getCustomerApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiGetCustomerApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Search customers" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Поиск кастомера по различным параметрам.
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param keyword string Слово, которое будем искать во всех полях кастомера
	 * @param name string Имя клиента
	 * @param email string E-mail клиента.
	 * @param minOrderCount number Минимальное количество заказов клиента.
	 * @param maxOrderCount number Максимальное количество заказов клиента.
	 * @param sortBy string Порядок сортировки клиентов. Допустимые значения:
     * NAME_ASC - сортировка по имени в алфавитном порядке;
     * NAME_DESC - сортировка по имени в обратном алфавитном порядке;
     * EMAIL_ASC - сортировка по email клиента(в алфавитном порядке);
     * EMAIL_DESC - сортировка по email клиента(в обратном алфавитном порядке);
     * ORDER_COUNT_ASC - сортировка по количеству заказов(от меньшего к большему);
     * ORDER_COUNT_DESC - сортировка по количеству заказов(от большего к меньшему).
     * Значение по дефолту - NAME_ASC
	 * @param offset number Смещение от начала списка. Нужно для пейджинга. Дефолтное значение 0(т.е. смещения нет,
     * отображаем с начала результирующего списка)
	 * @param limit number Максимальное количество элементов возвращаемых в выборке. Должно быть больше 0.
     * Максимальное значение 100. По умолчанию значение 10.
	 * @return _ApiSearchCustomerApiService
	 */
	public function searchCustomerApiService( $storeId, $token, $keyword, $name, $email, $minOrderCount, $maxOrderCount, $sortBy, $offset, $limit) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers");
		if ($token != null) $builder->setParameter("token",
			$token);
		if ($keyword != null) $builder->setParameter("keyword",
			$keyword);
		if ($name != null) $builder->setParameter("name",
			$name);
		if ($email != null) $builder->setParameter("email",
			$email);
		if ($minOrderCount != null) $builder->setParameter("minOrderCount",
			$minOrderCount);
		if ($maxOrderCount != null) $builder->setParameter("maxOrderCount",
			$maxOrderCount);
		if ($sortBy != null) $builder->setParameter("sortBy",
			$sortBy);
		if ($offset != null) $builder->setParameter("offset",
			$offset);
		if ($limit != null) $builder->setParameter("limit",
			$limit);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		return new _ApiSearchCustomerApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Delete a Customer" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Удаление клиента
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор удаляемого клиента
	 * @return _ApiDeleteCustomerApiService
	 */
	public function deleteCustomerApiService( $storeId, $token, $id) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		return new _ApiDeleteCustomerApiService($this->executor, $builder->build()
		);
	}

	/**
	 * Builds Request object for the "Create a customer" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Создание клиента магазина
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param body ApiCustomer 
	 * @return _ApiCreateCustomerApiService
	 */
	public function createCustomerApiService( $storeId, $token,ApiCustomer $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers");
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiCreateCustomerApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}

	/**
	 * Builds Request object for the "Update a customer" request.
	 * To actually execute the request, call the execute() method on the returned object.<p/>
	 * Изменение клиента
	 * @param storeId number ID of the Ecwid store.
	 * @param token string Oauth токен для доступа к данной функциональности
	 * @param id number Идентификатор клиента
	 * @param body ApiCustomer 
	 * @return _ApiUpdateCustomerApiService
	 */
	public function updateCustomerApiService( $storeId, $token, $id,ApiCustomer $body) {
		$builder = new _UriBuilder($this->url."/".$storeId."/customers/".$id);
		if ($token != null) $builder->setParameter("token",
			$token);
		
		if ($storeId == null) throw new IllegalArgumentException("No parameter storeId is set");
		
		if ($id == null) throw new IllegalArgumentException("No parameter id is set");
		
		if ($body == null) throw new IllegalArgumentException("No request body");
		return new _ApiUpdateCustomerApiService($this->executor, $builder->build()
		, new HttpEntity(json_encode($body->asJson()), HttpEntity::JSON));
	}
# use the additional-client-code xslt parameter to insert custom code here
	private static function boolean_param($val) {
		if ($val) return "true";
		else return "false";
	}

	private static function json_array($array, $transform) {
		$result = array();
		foreach ($array as $element) {
			$result[] = $transform($element);
		}
		return $result;
	}

	private static function json_map($map, $transform) {
		$result = array();
		foreach ($map as $key => $element) {
			$result[$key] = $transform($element);
		}
		return $result;
	}
}
			