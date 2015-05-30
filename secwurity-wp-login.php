<?php
/*
 * Plugin Name:       SeCWurity WP Login
 * Plugin URI:        http://www.cyber-warrior.org
 * Description:       SeCWurity WP Login protects your login page against different attack types...
 * Version:           2.1
 * Author:            slmsmsk
 * Author URI:        http://www.cyber-warrior.org/Forum/pop_up_profile.asp?profile=185271&ForumID=16
 * Text Domain:       secwurity-wp-login
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */
 

## Direk olarak ulaşımı kısıtlama ##
if (!defined('WPINC')){die;}

define("SCWL",true);

## Eklenti Sınıfı ##
class SCWL{
    
    ## Varsayilanlar ##
    private static $url_koruma_aktif = false;
    private static $login_koruma_aktif = false;
    
    private static $sifre = 'cw-pass';
    private static $sayi  = 3;
    private static $par = 'cyber';
    private static $deger = 'warrior';
    
    private static $plugin_folder_name = 'secwurity-wp-login';
    private static $plugin_name = 'SeCWurity WP Login';
	
    
    ## ayar isimleri ##
    const op_sifre = 'SCWL_sifre'; // güvenlik şifresi
    const op_sayi = 'SCWL_sayi'; // sorulacak karakter sayısı
    const op_par = 'SCWL_par'; // url parametresi
    const op_deger = 'SCWL_deger'; // url parametre değeri
    const op_url_durum = 'SCWL_url'; // url koruma özelliği durumu
    const op_login_durum = 'SCWL_login'; // login form koruma özelliği durumu
    
    
    public function __construct(){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php');
        self::$sifre = get_option(self::op_sifre);
        self::$sayi = get_option(self::op_sayi);
        self::$url_koruma_aktif = get_option(self::op_url_durum);
        self::$login_koruma_aktif = get_option(self::op_login_durum);
        self::$par = get_option(self::op_par);
        self::$deger = get_option(self::op_deger);
    }
    
    ## Eklenti Admin Paneli ##
    public static function admin(){
        add_menu_page('Cyber Warrior', 'Cyber Warrior', 'manage_options', 'cyber_warrior',array('SCWL','biz_kimiz'),plugins_url( '/secwurity-wp-login/images/icon.png' ), 90);
        add_submenu_page( 'cyber_warrior', 'Cyber-Warrior', __('Hakkımızda'), 'manage_options', 'cyber_warrior');
        add_submenu_page( 'cyber_warrior', 'Plugin Team', __('Plug-in Grubu'), 'manage_options', 'plugin_team',array('SCWL','plugin_team'));
        add_submenu_page( 'cyber_warrior', 'SeCWurity_WP_Login', __('Eklenti Ayarları'), 'manage_options', 'secwurity-wp-login',array('SCWL','ayarlar'));
    }
    
    ## Who Are We? Sayfası ##
    public static function biz_kimiz(){
?>
<div class='cw-login-security'>
    <h2><font color="#01DF01">C</font>yber-<font color="#01DF01">W</font>arrior TIM</h2>
    <img src='http://www.Cyber-Warrior.Org/images/Banner/05.gif' alt='Cyber-Warrior'/><br>
    <div class='cw-content' style="padding:10px 0;">
        <p>Grubumuz kurulduğu 2001 yılından beri kesintisiz  yayınını sürdürmektedir.</p>
        <p>Cyber-Warrior Bu süreç içerisinde birçok siteye ekol olmuş, Bilişim güvenliği konusunda uzman yüzlerce kişi yetiştirmiştir.</p>
        <p>2007 Yılında yapılan yasal düzenlemeler grubumuzunda mücadelesini verdiği birçok konuyu kapsamına almıştır.</p>
        <p>Genel anlamda hukuki boşluk doldurulmuştur.</p>
        <p>Bu sebeple mücadelemiz 2007 Yılından itibaren Yasalar çerçevesinde legal olarak devam etmektedir.</p>
    </div>
</div>
<?php
    }
    
    ## Plugin Team Sayfası ##
    public static function plugin_team(){
?>
<div class='cw-login-security'>
    <h2>Plugin-Tim</h2>
    <img src='http://www.Cyber-Warrior.Org/images/Banner/05.gif' alt='Cyber-Warrior'/><br>
    <div class='cw-content'>
        <div class="cw-head">Tim Lideri</div>
        <p><a href='http://www.cyber-warrior.org/Forum/pop_up_profile.asp?profile=100858'>BMNR</a></p>
        <div class="cw-head">Tim Personeli</div>
        <p><a href='http://www.cyber-warrior.org/Forum/pop_up_profile.asp?profile=185271'>prostorm</a></p>
    </div>
</div>
<?php
    }
    
    ## Eklentiye ayarlar butonu için ##
    static function ayarlar_butonu($links){
        $settings_link = '<a href="admin.php?page='.self::$plugin_folder_name.'">'.__('Settings','secwurity-wp-login').'</a>';
            array_push( $links, $settings_link );
            return $links;
    }
    
    ## Eklenti Paneli ##
    public static function ayarlar(){
        require 'form.php';
    }
    
    ## Aktif seçeneğinin seçilmesi için ##
    public static function select_box_aktif($par){
        if($par == true){
            return ' selected ';
        }
    }
    ## Pasif seçeneğinin seçilmesi için ##
    public static function select_box_pasif($par){
        if($par != true){
            return ' selected ';
        }
    }
    
    ## Eklenti etkinleştirilince çalışacak ##
    public static function ac(){
        add_option(self::op_sifre,self::$sifre);
        add_option(self::op_sayi,self::$sayi);
        add_option(self::op_par,self::$par);
        add_option(self::op_deger,self::$deger);
        add_option(self::op_url_durum,self::$url_koruma_aktif);
        add_option(self::op_login_durum,self::$login_koruma_aktif);
    }
    
    ## Eklenti durdurulunca çalışacak ##
    public static function kapat(){
        delete_option(self::op_sifre);
        delete_option(self::op_sayi);
        delete_option(self::op_par);
        delete_option(self::op_deger);
        delete_option(self::op_url_durum);
        delete_option(self::op_login_durum);
    }
    
    ## admin.css dosyası ekleniyor ##
    public static function admin_style(){
       wp_enqueue_style(self::$plugin_name,plugins_url( self::$plugin_folder_name.'/styles/admin.css'));
    }
    ## login.css dosyası ekleniyor ##
    public static function login_style(){
       wp_enqueue_style(self::$plugin_name,plugins_url( self::$plugin_folder_name.'/styles/login.css'));
    }
    
    public static function admin_script(){
        wp_enqueue_script(self::$plugin_name, plugins_url( self::$plugin_folder_name.'/js/toggle.js'), false);
    }
	
	public static function login_script() {
		?>
		<script type="text/javascript" src="<?php print plugins_url( self::$plugin_folder_name).'/js/jquery.js'; ?>"></script>
		<?php
		wp_enqueue_script( 'pass',plugins_url( self::$plugin_folder_name).'/js/pass.js', false );
	}
    
    public static function login_form(){
        
        ### Rastgele Karakter Sorma İşlemleri ###  
        $sifre = get_option(self::op_sifre);
        $s_sayi = get_option(self::op_sayi);
        ## Şifrenin karakter sayısı hesaplanıyor ##
        $k_sayi = strlen($sifre);
        ## Sorulacak karakter sayısı, şifre karakter sayısından fazla ise 1 karakter sorulacak ##
        if($s_sayi > $k_sayi or !is_numeric($s_sayi) or $s_sayi < 1){ $s_sayi = 1; }

        ## Şifre karakterleri dizide depolanıyor. ##
        $dizi = array();
        $dizi = str_split($sifre);
        $sayilar= array();
        $i=0;
        while($i<$s_sayi){
            $rastgele=rand(0,$k_sayi-1);
            if (!in_array($rastgele,$sayilar)){
                    $sayilar[]=$rastgele;
            $i++;
            }
        }
        sort($sayilar);
        print '<p class="cw-login-security">';
        print '<label for="">Güvenlik Şifreniz</label>';
            for($i = 0; $i<=$k_sayi-1; $i++){
                if(in_array($i,$sayilar)){
                        print '<input type="text" autocomplete="off" class="char"  name="'.$i.'" class="required" maxlength="1" required="required"/>';
                }else{
                        print '<input type="text" class="readonly" value="*" readonly="readonly" />';
                }
                if($i == $k_sayi-1){
                        print '<input type="hidden" name="sifre" value="1" />';
                }
            }
        print '</p>';
        ### Rastgele Karakter Sorma İşlemleri SON ###
        
    }
    
    ## Türkçe Karakter Temizleme İşlemi ##
    public static function t_karakter_temizle($kelime){
	$eski=array("ş","Ş","ı","ü","Ü","ö","Ö","ç","Ç","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","U","V","Y","Z","W","Q");
	$yeni=array("s","s","i","u","u","o","o","c","c","s","s","i","g","g","i","o","o","c","c","u","u","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","t","u","v","y","z","w","q");
	
	$kelime=str_replace($eski,$yeni,$kelime);
	$kelime = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i","-",$kelime);
	return $kelime;
    }
    
    
    ## Url parametre kontrol işlemi ##
    public static function url_kontrol(){
        print '<style type="text/css">
             .login_warn{
                    padding:0 20px;
                    color:#f00;
                    font-weight:bold;
                    margin:100px auto 0 auto;
                    width:400px; text-align:center;
                }
                .login_warn_bottom{
                    margin:0 auto;
                    width:400px;
                    text-align:center;
                    font-weight:bold;
                    font-size:10px;
                    color:#21C233;
                } 
             </style>';
        $d_adi = get_option(self::op_par);
	$d_deger = get_option(self::op_deger);
            if(isset($_GET['action']) and ($_GET['action'] == 'lostpassword' or $_GET['action'] == 'register')){

            }else if(isset($_GET['loggedout']) and $_GET['loggedout'] == true){
                print '<p class="login_warn">Çıkış yapıldı.</p>
                    <p class="login_warn_bottom">'.self::$plugin_name.'</p>';
                exit;
            }else if(isset($_GET["email"]) and $_GET["email"] == get_option('admin_email')){
                print '<p class="login_warn">'.home_url().'/wp-login.php?'.$d_adi.'='.$d_deger.'</p>
                       <p class="login_warn_bottom">'.self::$plugin_name.'</p>';
                exit;
            }else if(!isset($_GET[$d_adi]) or $_GET[$d_adi] != $d_deger){
				$url = get_bloginfo('url').'/404.php';
                header('Location: '.$url);
				die();
            }
    }
    
    ## Üye Şifre Kontrolü ##
    public static function sifre_kontrol($user, $username, $password){
        if($_POST):
            ## Kullanıcı bilgileri sorgulanıyor ##
            $user = get_user_by('login', $username );
            ## Şifre doğrulama işlemleri ##
            $sifre = get_option(self::op_sifre);
            $dizi = array();
            $dizi = str_split($sifre);

            $sonuc = true;
            foreach ($_POST as $key => $value){
                if(is_numeric($key)){
                    if($dizi[$key] != $value){
                        $sonuc = false;
                    }
                }
            }

            if(!$user or !$sonuc){
                ## Kullanıcı bilgileri yanlış ise işlem durduruluyor ##
                    remove_action('authenticate', 'wp_authenticate_username_password', 20); 

                ## Hata oluşturuluyor ##
                    $user = new WP_Error( 'denied', __("<strong>ERROR</strong>: You're unique identifier was invalid.") );
                    
                if(get_option(self::op_url_durum)){
                    $url = home_url().'/wp-login.php?'.get_option(self::op_par).'='.get_option(self::op_deger);
                    header("Location: {$url}");
                }
            } 
            return null;
            endif;
        }
    
}

## Eklenti açıldığında ac fonksiyonu çalışıtırılıyor ##
register_activation_hook(__FILE__,array('SCWL','ac'));
## Eklenti kapatıldığında kapat fonksiyonu çalıştırılıyor ##
register_deactivation_hook(__FILE__,array('SCWL','kapat'));

## Menü Ekleniyor ##
add_action('admin_menu', array('SCWL','admin'));

## css dosyası çağırılıyor ##
add_action( 'admin_init',array('SCWL','admin_style'));

## js dosyası çağırılıyor ##
add_action( 'admin_init', array('SCWL','admin_script') );

## ayarlar butonu ekleniyor ##
$plugin = plugin_basename(__FILE__);
add_filter( "plugin_action_links_$plugin", array('SCWL','ayarlar_butonu') );

if(get_option(SCWL::op_login_durum)){ 

    ## login sayfasına güvenlik şifresi ekleniyor ##
    add_action('login_form',array('SCWL','login_form'));
  
    ## Şifre kontrolü yapılıyor ##
    add_filter( 'authenticate', array('SCWL','sifre_kontrol'), 10, 3 );

}

if(get_option(SCWL::op_url_durum)){
    
    ## Url koruma fonksiyonu login sayfasına ekleniyor ##
    add_action('login_head', array('SCWL','url_kontrol'));
    
}

## login sayfası stil dosyası ##
add_action('login_head',array('SCWL','login_style'));
add_action('login_head',array('SCWL','login_style'));
add_action('login_enqueue_scripts',array('SCWL','login_script'));
