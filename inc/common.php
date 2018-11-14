<?php

use MR4Web\Configs\Config;
use MR4Web\Utils\Hooks;
use MR4Web\Models\Setting;

function _addslashes ($str)
{
    if (get_magic_quotes_gpc())
    {
        return $str;
    }
    else
    {
        return addslashes($str);
    }
}

function show2input(&$value)
{
    if (isset($value))
        echo htmlentities($value, ENT_QUOTES);
}

function checkParams($keys)
{
    foreach ($keys as $key)
    {
        if (!isset($_POST[$key]) || empty($_POST[$key]))
            return false;
    }

    return true;
}

function logger($string)
{
    if (DEBUG_SHOW_OPERATIONS)
        echo $string;
}

function getConfig($key)
{
    return Setting::get($key);
}

function getAllConfigs()
{
    return Setting::getSettings();
}

function sendEmail($to, $subject, $body, $from = [], $isHTML=true)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {

        if (strtolower(getConfig('email_method')) == 'smtp')
        {
            $mail->IsSMTP();
            $mail->Host = getConfig('SMTP_Host');
            $mail->Port = getConfig('SMTP_Port');
            $mail->Username = getConfig('SMTP_User');
            $mail->Password = getConfig('SMTP_Pass');
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = getConfig('mail_encription'); // ssl or tls
            //$mail->SMTPSecure = 'none';
            $mail->SMTPAutoTLS = false;

            if (getConfig('allow_SSL_Insecure_mode') == 1)
            {
                $mail->SMTPOptions = array(
                        'ssl' => [
                            'verify_peer'       => false,
                            'verify_peer_name'  => false,
                            'allow_self_signed' => true
                        ]
                    );
            }

        }
        else
        {
            //$mail->IsMail();
            $mail->IsSendmail();
        }

        if(count($from) == 2)
            $mail->SetFrom($from[0], $from[1]);
        else
            $mail->SetFrom(getConfig('email_from'), getConfig('site_name'));
        
        
        if ($isHTML)        
        {
            $mail->IsHTML(TRUE);
            $mail->Body = $body;
        }   
        else
        {
            $mail->IsHTML(FALSE);
            $mail->AltBody = $body;
        }

        if (is_string($to))
            $mail->AddAddress($to);
        else if (count($to) == 2)
            $mail->AddAddress($to[0], $to[1]);
        
        //$mail->addReplyTo("test@moaks.ws");

        $mail->Subject = $subject;
        if ($mail->Send())
            return true;


    } catch (PHPMailer\PHPMailer\Exception $e) {
        if (DEBUG_SHOW_ERRORS)
            die("PHPMailer Error: ".$mail->ErrorInfo);
        return false;
    }
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');

    return $ipaddress;
}

function MyCURL($URL, array $fields = array())
{
    $userAgent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : Config::get('user_agent');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_NOBODY, true);
    
    if ($userAgent != '')
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

    if (count($fields))
    {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    }

    $res = json_decode(curl_exec($ch), true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($res == false)
        $res = $httpCode;
    curl_close($ch);

    return $res;
}

function ping($host, $port=80, $timeout=10)
{
    $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($fsock)
        return true;
    return false;
}

function dots($num, $sym = '.')
{
    $dots = "";
    for ($i = 0; $i < $num; ++$i)
        $dots .= $sym;
    return $dots;
}

function console($msg)
{
    if (DEBUG_SHOW_MSGS_CONSOLE)
        echo $msg;
}

function roundPrice($price)
{
    return (float)substr($price, 0, strpos($price, '.')+3);
}

function printGenderGraph($index = NULL)
{
    switch ($index)
    {
        case 'F':
            return "<i class='fa fa-female text-danger'></i>";
        case 'M':
            return "<i class='fa fa-male text-primary'></i>";
        default:
            return NULL;
    }
}



/**
 * Add a new action hook
 *
 * @param mixed $name
 * @param mixed $function
 * @param mixed $priority
 */

function add_action($name, $function, $priority = 10)
{
    return Hooks::add_action($name, $function, $priority);
}
/**
 * Run an action
 *
 * @param mixed $name
 * @param mixed $arguments
 * @return mixed
 */
function do_action($name, ...$arguments)
{
    return Hooks::do_action($name, $arguments);
}
/**
 * Remove an action
 *
 * @param mixed $name
 * @param mixed $function
 * @param mixed $priority
 */
function remove_action($name, $function, $priority = 10)
{
    return Hooks::remove_action($name, $function, $priority);
}
/**
 * Check if an action exists
 *
 * @param mixed $name
 */
function action_exists($name)
{
    return Hooks::action_exists($name);
}

function get_country_menu ($name='',$class='',$select=0,$l='')
{
    $lang = 'en';
    $country = array();
    $country['ar'] = array(
        "اختر بلدك",
        "أفغانستان",
        "ألبانيا",
        "الجزائر",
        "أندورا",
        "أنغولا",
        "أنتيغوا وبربودا",
        "الأرجنتين",
        "أرمينيا",
        "أستراليا",
        "النمسا",
        "أذربيجان",
        "الباهاما",
        "البحرين",
        "بنغلاديش",
        "بربادوس",
        "روسيا البيضاء",
        "بلجيكا",
        "بليز",
        "بنين",
        "بوتان",
        "بوليفيا",
        "البوسنة والهرسك",
        "بوتسوانا",
        "البرازيل",
        "بروناي",
        "بلغاريا",
        "بوركينا فاسو",
        "بوروندي",
        "كمبوديا",
        "الكاميرون",
        "كندا",
        "الرأس الأخضر",
        "جمهورية افريقيا الوسطى",
        "تشاد",
        "شيلي",
        "الصين",
        "كولومبيا",
        "جزر القمر",
        "الكونغو (برازافيل)",
        "الكونغو",
        "كوستا ريكا",
        "كوت ديفوار",
        "كرواتيا",
        "كوبا",
        "قبرص",
        "جمهورية التشيك",
        "الدنمارك",
        "جيبوتي",
        "دومينيكا",
        "جمهورية الدومنيكان",
        "تيمور الشرقية (تيمور تيمورلنك)",
        "الاكوادور",
        "مصر",
        "السلفادور",
        "غينيا الإستوائية",
        "إريتريا",
        "استونيا",
        "أثيوبيا",
        "فيجي",
        "فنلندا",
        "فرنسا",
        "الغابون",
        "غامبيا",
        "جورجيا",
        "ألمانيا",
        "غانا",
        "اليونان",
        "غرينادا",
        "غواتيمالا",
        "غينيا",
        "غينيا بيساو",
        "غيانا",
        "هايتي",
        "هندوراس",
        "هنغاريا",
        "أيسلندا",
        "الهند",
        "أندونيسيا",
        "إيران",
        "العراق",
        "ايرلندا",
        "إيطاليا",
        "جامايكا",
        "اليابان",
        "الأردن",
        "كازاخستان",
        "كينيا",
        "كيريباس",
        "كوريا الشمالية",
        "كوريا، جنوب",
        "الكويت",
        "قيرغيزستان",
        "لاوس",
        "لاتفيا",
        "لبنان",
        "ليسوتو",
        "ليبيريا",
        "ليبيا",
        "ليختنشتاين",
        "ليتوانيا",
        "لوكسمبورغ",
        "مقدونيا",
        "مدغشقر",
        "ملاوي",
        "ماليزيا",
        "جزر المالديف",
        "مالي",
        "مالطا",
        "جزر مارشال",
        "موريتانيا",
        "موريشيوس",
        "المكسيك",
        "ميكرونيزيا",
        "مولدافيا",
        "موناكو",
        "منغوليا",
        "المغرب",
        "موزمبيق",
        "ميانمار",
        "ناميبيا",
        "ناورو",
        "نيبال",
        "هولندا",
        "نيوزيلاندا",
        "نيكاراغوا",
        "النيجر",
        "نيجيريا",
        "النرويج",
        "سلطنة عمان",
        "باكستان",
        "بالاو",
        "بنما",
        "بابوا غينيا الجديدة",
        "باراغواي",
        "بيرو",
        "الفلبين",
        "بولندا",
        "البرتغال",
        "قطر",
        "رومانيا",
        "روسيا",
        "رواندا",
        "سانت كيتس ونيفيس",
        "سانت لوسيا",
        "سانت فنسنت",
        "ساموا",
        "سان مارينو",
        "ساو تومي وبرينسيبي",
        "المملكة العربية السعودية",
        "السنغال",
        "صربيا والجبل الأسود",
        "سيشيل",
        "سيرا ليون",
        "سنغافورة",
        "سلوفاكيا",
        "سلوفينيا",
        "جزر سليمان",
        "الصومال",
        "جنوب أفريقيا",
        "إسبانيا",
        "سيريلانكا",
        "السودان",
        "سورينام",
        "سوازيلاند",
        "السويد",
        "سويسرا",
        "سوريا",
        "تايوان",
        "طاجيكستان",
        "تنزانيا",
        "تايلاند",
        "توغو",
        "تونغا",
        "ترينداد وتوباغو",
        "تونس",
        "ديك رومي",
        "تركمانستان",
        "توفالو",
        "أوغندا",
        "أوكرانيا",
        "الإمارات العربية المتحدة",
        "المملكة المتحدة",
        "الولايات المتحدة",
        "أوروغواي",
        "أوزبكستان",
        "فانواتو",
        "مدينة الفاتيكان",
        "فنزويلا",
        "فيتنام",
        "اليمن",
        "زامبيا",
        "زيمبابوي"
    );
    $country['en'] = array(
        "Choose your country",
        "Afghanistan",
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Botswana",
        "Brazil",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "colombia",
        "Comoros",
        "Congo (Brazzaville)",
        "Congo",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatia",
        "Cuba",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "East Timor (Timor Timur)",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Fiji",
        "Finland",
        "France",
        "Gabon",
        "Gambia, The",
        "Georgia",
        "Germany",
        "Ghana",
        "Greece",
        "Grenada",
        "Guatemala",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Honduras",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Italy",
        "Jamaica",
        "Japan",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, North",
        "Korea, South",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macedonia",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Mauritania",
        "Mauritius",
        "Mexico",
        "Micronesia",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Morocco",
        "Mozambique",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Poland",
        "Portugal",
        "Qatar",
        "Romania",
        "Russia",
        "Rwanda",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Vincent",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia and Montenegro",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Togo",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "United States",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Vatican City",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Zambia",
        "Zimbabwe"
    );

    $lang = (isset($country[$lang]))? $lang : 'en' ; 

    $select = ($select == '')? 0 : $select ;
    $dir = ($lang == 'en')? 'ltr' : 'rtl' ;
    $s = "<div dir='".$dir."'><select ";
    
    if ($name != '')
    {
        $s .= "name='".$name."' ";
    }
    
    if ($class != '')
    {
        $s .= "class='".$class."' required>";
    }
    
    foreach ($country[$lang] as $k => $v)
    {
        if ($select == $k)
        {
            $s .= "<option value='".$k."' disabled selected>".$v."</option>";
        }
        else
        {
            $s .= "<option value='".$k."' >".$v."</option>";
        }
    }
    $s .= "</select></div>";
    return $s;
}


?>