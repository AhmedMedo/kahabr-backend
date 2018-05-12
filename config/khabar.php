<?php
	use App\Feed;
	return[
	
		/*
	|--------------------------------------------------------------------------
	| Khabar Conifg files
	|--------------------------------------------------------------------------
	|
	| This config file is used to add your own configrations for the Webservices
	|
	*/
	
	/*
	|--------------------------------------------------------------------------
	| Number of Feeds Per Service Call
	|--------------------------------------------------------------------------
	|
	| Here you specify the number of feeds which will be parsed per service call to retrive news.
	|
	*/
	
		'Number_of_service_calls_per_day' =>288,
		'Number_of_trials'                =>12,

		
	/*
	|--------------------------------------------------------------------------
	| Related Countries
	|--------------------------------------------------------------------------
	|
	| Here you define countries that are related to each other
	|
	*/
		'Arab' =>['eg','inter','ae','dz','iq','jo','kw','lb','ps','sa','sd','sy','tn','tr'],
		
	/*
	|--------------------------------------------------------------------------
	| Countries List
	|--------------------------------------------------------------------------
	|  Here you define your countries list to be Used in the dropdown of the panel
	|
	*/
		'all_countries'=>[
				'' =>'International',
				'AF' => 'Afghanistan',
				'AX' => 'Aland Islands',
				'AL' => 'Albania',
				'DZ' => 'Algeria',
				'AS' => 'American Samoa',
				'AD' => 'Andorra',
				'AO' => 'Angola',
				'AI' => 'Anguilla',
				'AQ' => 'Antarctica',
				'AG' => 'Antigua And Barbuda',
				'AR' => 'Argentina',
				'AM' => 'Armenia',
				'AW' => 'Aruba',
				'AU' => 'Australia',
				'AT' => 'Austria',
				'AZ' => 'Azerbaijan',
				'BS' => 'Bahamas',
				'BH' => 'Bahrain',
				'BD' => 'Bangladesh',
				'BB' => 'Barbados',
				'BY' => 'Belarus',
				'BE' => 'Belgium',
				'BZ' => 'Belize',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BT' => 'Bhutan',
				'BO' => 'Bolivia',
				'BA' => 'Bosnia And Herzegovina',
				'BW' => 'Botswana',
				'BV' => 'Bouvet Island',
				'BR' => 'Brazil',
				'IO' => 'British Indian Ocean Territory',
				'BN' => 'Brunei Darussalam',
				'BG' => 'Bulgaria',
				'BF' => 'Burkina Faso',
				'BI' => 'Burundi',
				'KH' => 'Cambodia',
				'CM' => 'Cameroon',
				'CA' => 'Canada',
				'CV' => 'Cape Verde',
				'KY' => 'Cayman Islands',
				'CF' => 'Central African Republic',
				'TD' => 'Chad',
				'CL' => 'Chile',
				'CN' => 'China',
				'CX' => 'Christmas Island',
				'CC' => 'Cocos (Keeling) Islands',
				'CO' => 'Colombia',
				'KM' => 'Comoros',
				'CG' => 'Congo',
				'CD' => 'Congo, Democratic Republic',
				'CK' => 'Cook Islands',
				'CR' => 'Costa Rica',
				'CI' => 'Cote D\'Ivoire',
				'HR' => 'Croatia',
				'CU' => 'Cuba',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'DK' => 'Denmark',
				'DJ' => 'Djibouti',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'EC' => 'Ecuador',
				'EG' => 'Egypt',
				'SV' => 'El Salvador',
				'GQ' => 'Equatorial Guinea',
				'ER' => 'Eritrea',
				'EE' => 'Estonia',
				'ET' => 'Ethiopia',
				'FK' => 'Falkland Islands (Malvinas)',
				'FO' => 'Faroe Islands',
				'FJ' => 'Fiji',
				'FI' => 'Finland',
				'FR' => 'France',
				'GF' => 'French Guiana',
				'PF' => 'French Polynesia',
				'TF' => 'French Southern Territories',
				'GA' => 'Gabon',
				'GM' => 'Gambia',
				'GE' => 'Georgia',
				'DE' => 'Germany',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GR' => 'Greece',
				'GL' => 'Greenland',
				'GD' => 'Grenada',
				'GP' => 'Guadeloupe',
				'GU' => 'Guam',
				'GT' => 'Guatemala',
				'GG' => 'Guernsey',
				'GN' => 'Guinea',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HT' => 'Haiti',
				'HM' => 'Heard Island & Mcdonald Islands',
				'VA' => 'Holy See (Vatican City State)',
				'HN' => 'Honduras',
				'HK' => 'Hong Kong',
				'HU' => 'Hungary',
				'IS' => 'Iceland',
				'IN' => 'India',
				'ID' => 'Indonesia',
				'IR' => 'Iran, Islamic Republic Of',
				'IQ' => 'Iraq',
				'IE' => 'Ireland',
				'IM' => 'Isle Of Man',
				'IL' => 'Israel',
				'IT' => 'Italy',
				'JM' => 'Jamaica',
				'JP' => 'Japan',
				'JE' => 'Jersey',
				'JO' => 'Jordan',
				'KZ' => 'Kazakhstan',
				'KE' => 'Kenya',
				'KI' => 'Kiribati',
				'KR' => 'Korea',
				'KW' => 'Kuwait',
				'KG' => 'Kyrgyzstan',
				'LA' => 'Lao People\'s Democratic Republic',
				'LV' => 'Latvia',
				'LB' => 'Lebanon',
				'LS' => 'Lesotho',
				'LR' => 'Liberia',
				'LY' => 'Libyan Arab Jamahiriya',
				'LI' => 'Liechtenstein',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'MO' => 'Macao',
				'MK' => 'Macedonia',
				'MG' => 'Madagascar',
				'MW' => 'Malawi',
				'MY' => 'Malaysia',
				'MV' => 'Maldives',
				'ML' => 'Mali',
				'MT' => 'Malta',
				'MH' => 'Marshall Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MU' => 'Mauritius',
				'YT' => 'Mayotte',
				'MX' => 'Mexico',
				'FM' => 'Micronesia, Federated States Of',
				'MD' => 'Moldova',
				'MC' => 'Monaco',
				'MN' => 'Mongolia',
				'ME' => 'Montenegro',
				'MS' => 'Montserrat',
				'MA' => 'Morocco',
				'MZ' => 'Mozambique',
				'MM' => 'Myanmar',
				'NA' => 'Namibia',
				'NR' => 'Nauru',
				'NP' => 'Nepal',
				'NL' => 'Netherlands',
				'AN' => 'Netherlands Antilles',
				'NC' => 'New Caledonia',
				'NZ' => 'New Zealand',
				'NI' => 'Nicaragua',
				'NE' => 'Niger',
				'NG' => 'Nigeria',
				'NU' => 'Niue',
				'NF' => 'Norfolk Island',
				'MP' => 'Northern Mariana Islands',
				'NO' => 'Norway',
				'OM' => 'Oman',
				'PK' => 'Pakistan',
				'PW' => 'Palau',
				'PS' => 'Palestinian',
				'PA' => 'Panama',
				'PG' => 'Papua New Guinea',
				'PY' => 'Paraguay',
				'PE' => 'Peru',
				'PH' => 'Philippines',
				'PN' => 'Pitcairn',
				'PL' => 'Poland',
				'PT' => 'Portugal',
				'PR' => 'Puerto Rico',
				'QA' => 'Qatar',
				'RE' => 'Reunion',
				'RO' => 'Romania',
				'RU' => 'Russian Federation',
				'RW' => 'Rwanda',
				'BL' => 'Saint Barthelemy',
				'SH' => 'Saint Helena',
				'KN' => 'Saint Kitts And Nevis',
				'LC' => 'Saint Lucia',
				'MF' => 'Saint Martin',
				'PM' => 'Saint Pierre And Miquelon',
				'VC' => 'Saint Vincent And Grenadines',
				'WS' => 'Samoa',
				'SM' => 'San Marino',
				'ST' => 'Sao Tome And Principe',
				'SA' => 'Saudi Arabia',
				'SN' => 'Senegal',
				'RS' => 'Serbia',
				'SC' => 'Seychelles',
				'SL' => 'Sierra Leone',
				'SG' => 'Singapore',
				'SK' => 'Slovakia',
				'SI' => 'Slovenia',
				'SB' => 'Solomon Islands',
				'SO' => 'Somalia',
				'ZA' => 'South Africa',
				'GS' => 'South Georgia And Sandwich Isl.',
				'ES' => 'Spain',
				'LK' => 'Sri Lanka',
				'SD' => 'Sudan',
				'SR' => 'Suriname',
				'SJ' => 'Svalbard And Jan Mayen',
				'SZ' => 'Swaziland',
				'SE' => 'Sweden',
				'CH' => 'Switzerland',
				'SY' => 'Syrian Arab Republic',
				'TW' => 'Taiwan',
				'TJ' => 'Tajikistan',
				'TZ' => 'Tanzania',
				'TH' => 'Thailand',
				'TL' => 'Timor-Leste',
				'TG' => 'Togo',
				'TK' => 'Tokelau',
				'TO' => 'Tonga',
				'TT' => 'Trinidad And Tobago',
				'TN' => 'Tunisia',
				'TR' => 'Turkey',
				'TM' => 'Turkmenistan',
				'TC' => 'Turks And Caicos Islands',
				'TV' => 'Tuvalu',
				'UG' => 'Uganda',
				'UA' => 'Ukraine',
				'AE' => 'United Arab Emirates',
				'GB' => 'United Kingdom',
				'US' => 'United States',
				'UM' => 'United States Outlying Islands',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VU' => 'Vanuatu',
				'VE' => 'Venezuela',
				'VN' => 'Viet Nam',
				'VG' => 'Virgin Islands, British',
				'VI' => 'Virgin Islands, U.S.',
				'WF' => 'Wallis And Futuna',
				'EH' => 'Western Sahara',
				'YE' => 'Yemen',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe',

		
		],
		
	/*
	|--------------------------------------------------------------------------
	| Languages List
	|--------------------------------------------------------------------------
	|  Here you define your languages list to be Used in the dropdown of the panel
	|
	*/
		'languages' =>[
				'AF' => 'Afrikaans',
				'SQ' => 'Albanian',
				'AR' => 'Arabic',
				'HY' => 'Armenian',
				'EU' => 'Basque',
				'BN' => 'Bengali',
				'BG' => 'Bulgarian',
				'CA' => 'Catalan',
				'KM' => 'Cambodian',
				'ZH' => 'Chinese (Mandarin)',
				'HR' => 'Croatian',
				'CS' => 'Czech',
				'DA' => 'Danish',
				'NL' => 'Dutch',
				'EN' => 'English',
				'ET' => 'Estonian',
				'FJ' => 'Fiji',
				'FI' => 'Finnish',
				'FR' => 'French',
				'KA' => 'Georgian',
				'DE' => 'German',
				'EL' => 'Greek',
				'GU' => 'Gujarati',
				'HE' => 'Hebrew',
				'HI' => 'Hindi',
				'HU' => 'Hungarian',
				'IS' => 'Icelandic',
				'ID' => 'Indonesian',
				'GA' => 'Irish',
				'IT' => 'Italian',
				'JA' => 'Japanese',
				'JW' => 'Javanese',
				'KO' => 'Korean',
				'LA' => 'Latin',
				'LV' => 'Latvian',
				'LT' => 'Lithuanian',
				'MK' => 'Macedonian',
				'MS' => 'Malay',
				'ML' => 'Malayalam',
				'MT' => 'Maltese',
				'MI' => 'Maori',
				'MR' => 'Marathi',
				'MN' => 'Mongolian',
				'NE' => 'Nepali',
				'NO' => 'Norwegian',
				'FA' => 'Persian',
				'PL' => 'Polish',
				'PT' => 'Portuguese',
				'PA' => 'Punjabi',
				'QU' => 'Quechua',
				'RO' => 'Romanian',
				'RU' => 'Russian',
				'SM' => 'Samoan',
				'SR' => 'Serbian',
				'SK' => 'Slovak',
				'SL' => 'Slovenian',
				'ES' => 'Spanish',
				'SW' => 'Swahili',
				'SV' => 'Swedish ',
				'TA' => 'Tamil',
				'TT' => 'Tatar',
				'TE' => 'Telugu',
				'TH' => 'Thai',
				'BO' => 'Tibetan',
				'TO' => 'Tonga',
				'TR' => 'Turkish',
				'UK' => 'Ukrainian',
				'UR' => 'Urdu',
				'UZ' => 'Uzbek',
				'VI' => 'Vietnamese',
				'CY' => 'Welsh',
				'XH' => 'Xhosa'

		],
	
	
	
	/*
	|--------------------------------------------------------------------------
	| Backup Configrations
	|--------------------------------------------------------------------------
	|  Here you define  the counfigrations used in News backup service
	|
	*/
	
	/*
		Number of days 
	*/
	
		'days' =>10,
        'backup_time'=>'8:30',
	
	/*News limit*/
        /*
        |--------------------------------------------------------------------------
        | Limit Configrations
        |--------------------------------------------------------------------------
        |  Define all limit configrations
        |
        */
	    'news_limit' =>30,
        'facebook_limit' =>10,
	
	
	
	];


?>