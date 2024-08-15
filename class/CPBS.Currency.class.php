<?php

/******************************************************************************/
/******************************************************************************/

class CPBSCurrency
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->currency=CPBSGlobalData::setGlobalData('currency',array($this,'init'));
	}
	
	/**************************************************************************/
	
	function init()
	{
		$currency=array
		(
			'AFN'=>array
			(
				'name'=>esc_html__('Afghan afghani','car-park-booking-system'),
				'symbol'=>'AFN'
			),
			'ALL'=>array
			(
				'name'=>esc_html__('Albanian lek','car-park-booking-system'),
				'symbol'=>'ALL'
			),
			'DZD'=>array
			(
				'name'=>esc_html__('Algerian dinar','car-park-booking-system'),
				'symbol'=>'DZD'
			),
			'AOA'=>array
			(
				'name'=>esc_html__('Angolan kwanza','car-park-booking-system'),
				'symbol'=>'AOA'
			),
			'ARS'=>array
			(
				'name'=>esc_html__('Argentine peso','car-park-booking-system'),
				'symbol'=>'ARS'
			),
			'AMD'=>array
			(
				'name'=>esc_html__('Armenian dram','car-park-booking-system'),
				'symbol'=>'AMD'
			),
			'AWG'=>array
			(
				'name'=>esc_html__('Aruban florin','car-park-booking-system'),
				'symbol'=>'AWG'
			),
			'AUD'=>array
			(
				'name'=>esc_html__('Australian dollar','car-park-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'AZN'=>array
			(
				'name'=>esc_html__('Azerbaijani manat','car-park-booking-system'),
				'symbol'=>'AZN'
			),
			'BSD'=>array
			(
				'name'=>esc_html__('Bahamian dollar','car-park-booking-system'),
				'symbol'=>'BSD'
			),
			'BHD'=>array
			(
				'name'=>esc_html__('Bahraini dinar','car-park-booking-system'),
				'symbol'=>'BHD',
				'separator'=>'&#1643;'
			),
			'BDT'=>array
			(
				'name'=>esc_html__('Bangladeshi taka','car-park-booking-system'),
				'symbol'=>'BDT'
			),
			'BBD'=>array
			(
				'name'=>esc_html__('Barbadian dollar','car-park-booking-system'),
				'symbol'=>'BBD'
			),
			'BYR'=>array
			(
				'name'=>esc_html__('Belarusian ruble','car-park-booking-system'),
				'symbol'=>'BYR'
			),
			'BZD'=>array
			(
				'name'=>esc_html__('Belize dollar','car-park-booking-system'),
				'symbol'=>'BZD'
			),
			'BTN'=>array
			(
				'name'=>esc_html__('Bhutanese ngultrum','car-park-booking-system'),
				'symbol'=>'BTN'
			),
			'BOB'=>array
			(
				'name'=>esc_html__('Bolivian boliviano','car-park-booking-system'),
				'symbol'=>'BOB'
			),
			'BAM'=>array
			(
				'name'=>esc_html__('Bosnia and Herzegovina konvertibilna marka','car-park-booking-system'),
				'symbol'=>'BAM'
			),
			'BWP'=>array
			(
				'name'=>esc_html__('Botswana pula','car-park-booking-system'),
				'symbol'=>'BWP',
				'separator'=>'.'
			),
			'BRL'=>array
			(
				'name'=>esc_html__('Brazilian real','car-park-booking-system'),
				'symbol'=>'&#82;&#36;'
			),
			'GBP'=>array
			(
				'name'=>esc_html__('British pound','car-park-booking-system'),
				'symbol'=>'&pound;',
				'position'=>'left',
				'separator'=>'.',
			),
			'BND'=>array
			(
				'name'=>esc_html__('Brunei dollar','car-park-booking-system'),
				'symbol'=>'BND',
				'separator'=>'.'
			),
			'BGN'=>array
			(
				'name'=>esc_html__('Bulgarian lev','car-park-booking-system'),
				'symbol'=>'BGN'
			),
			'BIF'=>array
			(
				'name'=>esc_html__('Burundi franc','car-park-booking-system'),
				'symbol'=>'BIF'
			),
			'KYD'=>array
			(
				'name'=>esc_html__('Cayman Islands dollar','car-park-booking-system'),
				'symbol'=>'KYD'
			),
			'KHR'=>array
			(
				'name'=>esc_html__('Cambodian riel','car-park-booking-system'),
				'symbol'=>'KHR'
			),
			'CAD'=>array
			(
				'name'=>esc_html__('Canadian dollar','car-park-booking-system'),
				'symbol'=>'CAD',
				'separator'=>'.'
			),
			'CVE'=>array
			(
				'name'=>esc_html__('Cape Verdean escudo','car-park-booking-system'),
				'symbol'=>'CVE'
			),
			'XAF'=>array
			(
				'name'=>esc_html__('Central African CFA franc','car-park-booking-system'),
				'symbol'=>'XAF'
			),
			'GQE'=>array
			(
				'name'=>esc_html__('Central African CFA franc','car-park-booking-system'),
				'symbol'=>'GQE'
			),
			'XPF'=>array
			(
				'name'=>esc_html__('CFP franc','car-park-booking-system'),
				'symbol'=>'XPF'
			),
			'CLP'=>array
			(
				'name'=>esc_html__('Chilean peso','car-park-booking-system'),
				'symbol'=>'CLP'
			),
			'CNY'=>array
			(
				'name'=>esc_html__('Chinese renminbi','car-park-booking-system'),
				'symbol'=>'&yen;'
			),
			'COP'=>array
			(
				'name'=>esc_html__('Colombian peso','car-park-booking-system'),
				'symbol'=>'COP'
			),
			'KMF'=>array
			(
				'name'=>esc_html__('Comorian franc','car-park-booking-system'),
				'symbol'=>'KMF'
			),
			'CDF'=>array
			(
				'name'=>esc_html__('Congolese franc','car-park-booking-system'),
				'symbol'=>'CDF'
			),
			'CRC'=>array
			(
				'name'=>esc_html__('Costa Rican colon','car-park-booking-system'),
				'symbol'=>'CRC'
			),
			'HRK'=>array
			(
				'name'=>esc_html__('Croatian kuna','car-park-booking-system'),
				'symbol'=>'HRK'
			),
			'CUC'=>array
			(
				'name'=>esc_html__('Cuban peso','car-park-booking-system'),
				'symbol'=>'CUC'
			),
			'CZK'=>array
			(
				'name'=>esc_html__('Czech koruna','car-park-booking-system'),
				'symbol'=>'&#75;&#269;'
			),
			'DKK'=>array
			(
				'name'=>esc_html__('Danish krone','car-park-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'DJF'=>array
			(
				'name'=>esc_html__('Djiboutian franc','car-park-booking-system'),
				'symbol'=>'DJF'
			),
			'DOP'=>array
			(
				'name'=>esc_html__('Dominican peso','car-park-booking-system'),
				'symbol'=>'DOP',
				'separator'=>'.'
			),
			'XCD'=>array
			(
				'name'=>esc_html__('East Caribbean dollar','car-park-booking-system'),
				'symbol'=>'XCD'
			),
			'EGP'=>array
			(
				'name'=>esc_html__('Egyptian pound','car-park-booking-system'),
				'symbol'=>'EGP'
			),
			'ERN'=>array
			(
				'name'=>esc_html__('Eritrean nakfa','car-park-booking-system'),
				'symbol'=>'ERN'
			),
			'EEK'=>array
			(
				'name'=>esc_html__('Estonian kroon','car-park-booking-system'),
				'symbol'=>'EEK'
			),
			'ETB'=>array
			(
				'name'=>esc_html__('Ethiopian birr','car-park-booking-system'),
				'symbol'=>'ETB'
			),
			'EUR'=>array
			(
				'name'=>esc_html__('European euro','car-park-booking-system'),
				'symbol'=>'&euro;'
			),
			'FKP'=>array
			(
				'name'=>esc_html__('Falkland Islands pound','car-park-booking-system'),
				'symbol'=>'FKP'
			),
			'FJD'=>array
			(
				'name'=>esc_html__('Fijian dollar','car-park-booking-system'),
				'symbol'=>'FJD',
				'separator'=>'.'
			),
			'GMD'=>array
			(
				'name'=>esc_html__('Gambian dalasi','car-park-booking-system'),
				'symbol'=>'GMD'
			),
			'GEL'=>array
			(
				'name'=>esc_html__('Georgian lari','car-park-booking-system'),
				'symbol'=>'GEL'
			),
			'GHS'=>array
			(
				'name'=>esc_html__('Ghanaian cedi','car-park-booking-system'),
				'symbol'=>'GHS'
			),
			'GIP'=>array
			(
				'name'=>esc_html__('Gibraltar pound','car-park-booking-system'),
				'symbol'=>'GIP'
			),
			'GTQ'=>array
			(
				'name'=>esc_html__('Guatemalan quetzal','car-park-booking-system'),
				'symbol'=>'GTQ',
				'separator'=>'.'
			),
			'GNF'=>array
			(
				'name'=>esc_html__('Guinean franc','car-park-booking-system'),
				'symbol'=>'GNF'
			),
			'GYD'=>array
			(
				'name'=>esc_html__('Guyanese dollar','car-park-booking-system'),
				'symbol'=>'GYD'
			),
			'HTG'=>array
			(
				'name'=>esc_html__('Haitian gourde','car-park-booking-system'),
				'symbol'=>'HTG'
			),
			'HNL'=>array
			(
				'name'=>esc_html__('Honduran lempira','car-park-booking-system'),
				'symbol'=>'HNL',
				'separator'=>'.'
			),
			'HKD'=>array
			(
				'name'=>esc_html__('Hong Kong dollar','car-park-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'HUF'=>array
			(
				'name'=>esc_html__('Hungarian forint','car-park-booking-system'),
				'symbol'=>'&#70;&#116;'
			),
			'ISK'=>array
			(
				'name'=>esc_html__('Icelandic krona','car-park-booking-system'),
				'symbol'=>'ISK'
			),
			'INR'=>array
			(
				'name'=>esc_html__('Indian rupee','car-park-booking-system'),
				'symbol'=>'&#8377;',
				'separator'=>'.'
			),
			'IDR'=>array
			(
				'name'=>esc_html__('Indonesian rupiah','car-park-booking-system'),
				'symbol'=>'Rp',
				'position'=>'left'
			),
			'IRR'=>array
			(
				'name'=>esc_html__('Iranian rial','car-park-booking-system'),
				'symbol'=>'IRR',
				'separator'=>'&#1643;'
			),
			'IQD'=>array
			(
				'name'=>esc_html__('Iraqi dinar','car-park-booking-system'),
				'symbol'=>'IQD',
				'separator'=>'&#1643;'
			),
			'ILS'=>array
			(
				'name'=>esc_html__('Israeli new sheqel','car-park-booking-system'),
				'symbol'=>'&#8362;',
				'separator'=>'.'
			),
			'YER'=>array
			(
				'name'=>esc_html__('Yemeni rial','car-park-booking-system'),
				'symbol'=>'YER'
			),
			'JMD'=>array
			(
				'name'=>esc_html__('Jamaican dollar','car-park-booking-system'),
				'symbol'=>'JMD'
			),
			'JPY'=>array
			(
				'name'=>esc_html__('Japanese yen','car-park-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			),
			'JOD'=>array
			(
				'name'=>esc_html__('Jordanian dinar','car-park-booking-system'),
				'symbol'=>'JOD'
			),
			'KZT'=>array
			(
				'name'=>esc_html__('Kazakhstani tenge','car-park-booking-system'),
				'symbol'=>'KZT'
			),
			'KES'=>array
			(
				'name'=>esc_html__('Kenyan shilling','car-park-booking-system'),
				'symbol'=>'KES'
			),
			'KGS'=>array
			(
				'name'=>esc_html__('Kyrgyzstani som','car-park-booking-system'),
				'symbol'=>'KGS'
			),
			'KWD'=>array
			(
				'name'=>esc_html__('Kuwaiti dinar','car-park-booking-system'),
				'symbol'=>'KWD',
				'separator'=>'&#1643;'
			),
			'LAK'=>array
			(
				'name'=>esc_html__('Lao kip','car-park-booking-system'),
				'symbol'=>'LAK'
			),
			'LVL'=>array
			(
				'name'=>esc_html__('Latvian lats','car-park-booking-system'),
				'symbol'=>'LVL'
			),
			'LBP'=>array
			(
				'name'=>esc_html__('Lebanese lira','car-park-booking-system'),
				'symbol'=>'LBP'
			),
			'LSL'=>array
			(
				'name'=>esc_html__('Lesotho loti','car-park-booking-system'),
				'symbol'=>'LSL'
			),
			'LRD'=>array
			(
				'name'=>esc_html__('Liberian dollar','car-park-booking-system'),
				'symbol'=>'LRD'
			),
			'LYD'=>array
			(
				'name'=>esc_html__('Libyan dinar','car-park-booking-system'),
				'symbol'=>'LYD'
			),
			'LTL'=>array
			(
				'name'=>esc_html__('Lithuanian litas','car-park-booking-system'),
				'symbol'=>'LTL'
			),
			'MOP'=>array
			(
				'name'=>esc_html__('Macanese pataca','car-park-booking-system'),
				'symbol'=>'MOP'
			),
			'MKD'=>array
			(
				'name'=>esc_html__('Macedonian denar','car-park-booking-system'),
				'symbol'=>'MKD'
			),
			'MGA'=>array
			(
				'name'=>esc_html__('Malagasy ariary','car-park-booking-system'),
				'symbol'=>'MGA'
			),
			'MYR'=>array
			(
				'name'=>esc_html__('Malaysian ringgit','car-park-booking-system'),
				'symbol'=>'&#82;&#77;',
				'separator'=>'.'
			),
			'MWK'=>array
			(
				'name'=>esc_html__('Malawian kwacha','car-park-booking-system'),
				'symbol'=>'MWK'
			),
			'MVR'=>array
			(
				'name'=>esc_html__('Maldivian rufiyaa','car-park-booking-system'),
				'symbol'=>'MVR'
			),
			'MRO'=>array
			(
				'name'=>esc_html__('Mauritanian ouguiya','car-park-booking-system'),
				'symbol'=>'MRO'
			),
			'MUR'=>array
			(
				'name'=>esc_html__('Mauritian rupee','car-park-booking-system'),
				'symbol'=>'MUR'
			),
			'MXN'=>array
			(
				'name'=>esc_html__('Mexican peso','car-park-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'MMK'=>array
			(
				'name'=>esc_html__('Myanma kyat','car-park-booking-system'),
				'symbol'=>'MMK'
			),
			'MDL'=>array
			(
				'name'=>esc_html__('Moldovan leu','car-park-booking-system'),
				'symbol'=>'MDL'
			),
			'MNT'=>array
			(
				'name'=>esc_html__('Mongolian tugrik','car-park-booking-system'),
				'symbol'=>'MNT'
			),
			'MAD'=>array
			(
				'name'=>esc_html__('Moroccan dirham','car-park-booking-system'),
				'symbol'=>'MAD',
				'position'=>'right'
			),
			'MZM'=>array
			(
				'name'=>esc_html__('Mozambican metical','car-park-booking-system'),
				'symbol'=>'MZM'
			),
			'NAD'=>array
			(
				'name'=>esc_html__('Namibian dollar','car-park-booking-system'),
				'symbol'=>'NAD'
			),
			'NPR'=>array
			(
				'name'=>esc_html__('Nepalese rupee','car-park-booking-system'),
				'symbol'=>'NPR'
			),
			'ANG'=>array
			(
				'name'=>esc_html__('Netherlands Antillean gulden','car-park-booking-system'),
				'symbol'=>'ANG'
			),
			'TWD'=>array
			(
				'name'=>esc_html__('New Taiwan dollar','car-park-booking-system'),
				'symbol'=>'&#78;&#84;&#36;',
				'separator'=>'.'
			),
			'NZD'=>array
			(
				'name'=>esc_html__('New Zealand dollar','car-park-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'NIO'=>array
			(
				'name'=>esc_html__('Nicaraguan cordoba','car-park-booking-system'),
				'symbol'=>'NIO',
				'separator'=>'.'
			),
			'NGN'=>array
			(
				'name'=>esc_html__('Nigerian naira','car-park-booking-system'),
				'symbol'=>'NGN',
				'separator'=>'.'
			),
			'KPW'=>array
			(
				'name'=>esc_html__('North Korean won','car-park-booking-system'),
				'symbol'=>'KPW',
				'separator'=>'.'
			),
			'NOK'=>array
			(
				'name'=>esc_html__('Norwegian krone','car-park-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'OMR'=>array
			(
				'name'=>esc_html__('Omani rial','car-park-booking-system'),
				'symbol'=>'OMR',
				'separator'=>'&#1643;'
			),
			'TOP'=>array
			(
				'name'=>esc_html__('Paanga','car-park-booking-system'),
				'symbol'=>'TOP'
			),
			'PKR'=>array
			(
				'name'=>esc_html__('Pakistani rupee','car-park-booking-system'),
				'symbol'=>'PKR',
				'separator'=>'.'
			),
			'PAB'=>array
			(
				'name'=>esc_html__('Panamanian balboa','car-park-booking-system'),
				'symbol'=>'PAB',
				'separator'=>'.'
			),
			'PGK'=>array
			(
				'name'=>esc_html__('Papua New Guinean kina','car-park-booking-system'),
				'symbol'=>'PGK'
			),
			'PYG'=>array
			(
				'name'=>esc_html__('Paraguayan guarani','car-park-booking-system'),
				'symbol'=>'PYG'
			),
			'PEN'=>array
			(
				'name'=>esc_html__('Peruvian nuevo sol','car-park-booking-system'),
				'symbol'=>'PEN'
			),
			'PHP'=>array
			(
				'name'=>esc_html__('Philippine peso','car-park-booking-system'),
				'symbol'=>'&#8369;'
			),
			'PLN'=>array
			(
				'name'=>esc_html__('Polish zloty','car-park-booking-system'),
				'symbol'=>'&#122;&#322;',
				'position'=>'right'
			),
			'QAR'=>array
			(
				'name'=>esc_html__('Qatari riyal','car-park-booking-system'),
				'symbol'=>'QAR',
				'separator'=>'&#1643;'
			),
			'RON'=>array
			(
				'name'=>esc_html__('Romanian leu','car-park-booking-system'),
				'symbol'=>'lei'
			),
			'RUB'=>array
			(
				'name'=>esc_html__('Russian ruble','car-park-booking-system'),
				'symbol'=>'RUB'
			),
			'RWF'=>array
			(
				'name'=>esc_html__('Rwandan franc','car-park-booking-system'),
				'symbol'=>'RWF'
			),
			'SHP'=>array
			(
				'name'=>esc_html__('Saint Helena pound','car-park-booking-system'),
				'symbol'=>'SHP'
			),
			'WST'=>array
			(
				'name'=>esc_html__('Samoan tala','car-park-booking-system'),
				'symbol'=>'WST'
			),
			'STD'=>array
			(
				'name'=>esc_html__('Sao Tome and Principe dobra','car-park-booking-system'),
				'symbol'=>'STD'
			),
			'SAR'=>array
			(
				'name'=>esc_html__('Saudi riyal','car-park-booking-system'),
				'symbol'=>'SAR',
				'separator'=>'&#1643;'
			),
			'SCR'=>array
			(
				'name'=>esc_html__('Seychellois rupee','car-park-booking-system'),
				'symbol'=>'SCR'
			),
			'RSD'=>array
			(
				'name'=>esc_html__('Serbian dinar','car-park-booking-system'),
				'symbol'=>'RSD'
			),
			'SLL'=>array
			(
				'name'=>esc_html__('Sierra Leonean leone','car-park-booking-system'),
				'symbol'=>'SLL'
			),
			'SGD'=>array
			(
				'name'=>esc_html__('Singapore dollar','car-park-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'SYP'=>array
			(
				'name'=>esc_html__('Syrian pound','car-park-booking-system'),
				'symbol'=>'SYP',
				'separator'=>'&#1643;'
			),
			'SKK'=>array
			(
				'name'=>esc_html__('Slovak koruna','car-park-booking-system'),
				'symbol'=>'SKK'
			),
			'SBD'=>array
			(
				'name'=>esc_html__('Solomon Islands dollar','car-park-booking-system'),
				'symbol'=>'SBD'
			),
			'SOS'=>array
			(
				'name'=>esc_html__('Somali shilling','car-park-booking-system'),
				'symbol'=>'SOS'
			),
			'ZAR'=>array
			(
				'name'=>esc_html__('South African rand','car-park-booking-system'),
				'symbol'=>'&#82;'
			),
			'KRW'=>array
			(
				'name'=>esc_html__('South Korean won','car-park-booking-system'),
				'symbol'=>'&#8361;',
				'separator'=>'.'
			),
			'XDR'=>array
			(
				'name'=>esc_html__('Special Drawing Rights','car-park-booking-system'),
				'symbol'=>'XDR'
			),
			'LKR'=>array
			(
				'name'=>esc_html__('Sri Lankan rupee','car-park-booking-system'),
				'symbol'=>'LKR',
				'separator'=>'.'
			),
			'SDG'=>array
			(
				'name'=>esc_html__('Sudanese pound','car-park-booking-system'),
				'symbol'=>'SDG'
			),
			'SRD'=>array
			(
				'name'=>esc_html__('Surinamese dollar','car-park-booking-system'),
				'symbol'=>'SRD'
			),
			'SZL'=>array
			(
				'name'=>esc_html__('Swazi lilangeni','car-park-booking-system'),
				'symbol'=>'SZL'
			),
			'SEK'=>array
			(
				'name'=>esc_html__('Swedish krona','car-park-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'CHF'=>array
			(
				'name'=>esc_html__('Swiss franc','car-park-booking-system'),
				'symbol'=>'&#67;&#72;&#70;',
				'separator'=>'.'
			),
			'TJS'=>array
			(
				'name'=>esc_html__('Tajikistani somoni','car-park-booking-system'),
				'symbol'=>'TJS'
			),
			'TZS'=>array
			(
				'name'=>esc_html__('Tanzanian shilling','car-park-booking-system'),
				'symbol'=>'TZS'
			),
			'THB'=>array
			(
				'name'=>esc_html__('Thai baht','car-park-booking-system'),
				'symbol'=>'&#3647;'
			),
			'TTD'=>array
			(
				'name'=>esc_html__('Trinidad and Tobago dollar','car-park-booking-system'),
				'symbol'=>'TTD'
			),
			'TND'=>array
			(
				'name'=>esc_html__('Tunisian dinar','car-park-booking-system'),
				'symbol'=>'TND'
			),
			'TRY'=>array
			(
				'name'=>esc_html__('Turkish new lira','car-park-booking-system'),
				'symbol'=>'&#84;&#76;'
			),
			'TMM'=>array
			(
				'name'=>esc_html__('Turkmen manat','car-park-booking-system'),
				'symbol'=>'TMM'
			),
			'AED'=>array
			(
				'name'=>esc_html__('UAE dirham','car-park-booking-system'),
				'symbol'=>'AED'
			),
			'UGX'=>array
			(
				'name'=>esc_html__('Ugandan shilling','car-park-booking-system'),
				'symbol'=>'UGX'
			),
			'UAH'=>array
			(
				'name'=>esc_html__('Ukrainian hryvnia','car-park-booking-system'),
				'symbol'=>'UAH'
			),
			'USD'=>array
			(
				'name'=>esc_html__('United States dollar','car-park-booking-system'),
				'symbol'=>'&#36;',
				'position'=>'left',
				'separator'=>'.',
				'separator2'=>''
			),
			'UYU'=>array
			(
				'name'=>esc_html__('Uruguayan peso','car-park-booking-system'),
				'symbol'=>'UYU'
			),
			'UZS'=>array
			(
				'name'=>esc_html__('Uzbekistani som','car-park-booking-system'),
				'symbol'=>'UZS'
			),
			'VUV'=>array
			(
				'name'=>esc_html__('Vanuatu vatu','car-park-booking-system'),
				'symbol'=>'VUV'
			),
			'VEF'=>array
			(
				'name'=>esc_html__('Venezuelan bolivar','car-park-booking-system'),
				'symbol'=>'VEF'
			),
			'VND'=>array
			(
				'name'=>esc_html__('Vietnamese dong','car-park-booking-system'),
				'symbol'=>'VND'
			),
			'XOF'=>array
			(
				'name'=>esc_html__('West African CFA franc','car-park-booking-system'),
				'symbol'=>'XOF'
			),
			'ZMK'=>array
			(
				'name'=>esc_html__('Zambian kwacha','car-park-booking-system'),
				'symbol'=>'ZMK'
			),
			'ZWD'=>array
			(
				'name'=>esc_html__('Zimbabwean dollar','car-park-booking-system'),
				'symbol'=>'ZWD'
			),
			'RMB'=>array
			(
				'name'=>esc_html__('Chinese Yuan','car-park-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			)
		);
		
		$currency=$this->useDefault($currency);
		return($currency);
	}
	
	/**************************************************************************/
	
	function useDefault($currency)
	{
		foreach($currency as $index=>$value)
		{
			if(!array_key_exists('separator',$value))
				$currency[$index]['separator']='.';
			if(!array_key_exists('separator2',$value))
				$currency[$index]['separator2']='';
			if(!array_key_exists('position',$value))
				$currency[$index]['position']='left';			
		}
		
		return($currency);
	}
	
	/**************************************************************************/
	
	function getCurrency($currency=null)
	{
		if(is_null($currency))
			return($this->currency);
		else return($this->currency[$currency]);
	}
	
	/**************************************************************************/
	
	function isCurrency($currency)
	{
		return(array_key_exists($currency,$this->getCurrency()));
	}
	
	/**************************************************************************/

	static function getBaseCurrency()
	{
		return(CPBSOption::getOption('currency'));
	}
	
	/**************************************************************************/
	
	static function getFormCurrency()
	{
		if(array_key_exists('currency',$_GET))
			$currency=CPBSHelper::getGetValue('currency',false);
		else $currency=CPBSHelper::getPostValue('currency');
		
		return($currency);
	}
	
	/**************************************************************************/
	
	static function getExchangeRate()
	{
		$rate=1;
		
		if(CPBSCurrency::getBaseCurrency()!=CPBSCurrency::getFormCurrency())
		{
			$rate=0;
			$dictionary=CPBSOption::getOption('currency_exchange_rate');
			
			if(array_key_exists(CPBSCurrency::getFormCurrency(),$dictionary))
				$rate=$dictionary[CPBSCurrency::getFormCurrency()];
		}
		
		return($rate);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/