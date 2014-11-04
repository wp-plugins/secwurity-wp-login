<?php if(!defined("SCWL")){ die(); }
    $title = self::$plugin_name;
    $title = str_replace("CW","<font color='#01DF01'>CW</font>",$title);
    print "<form method='post' class='cw-login-security' action=''>
	<h2>".$title." - ".__('Settings')."</h2>
        <?php print get_option(self::op_sifre); ?>
	<ul>
		<li>".__('En az 5 karakter içeren şifre yazmanız önerilir.')."</li>
		<li>".__('Şifrenizi unutursanız sadece veritabanına erişerek değiştirebilirsiniz.')."</li>
		<li>".__('Şifreleri boş bırakırsanız, önceki şifre geçerli olacaktır.')."</li>
                <li>".__("Eklenti aktif olduğunda varsayılan şifre 'cw-pass' olmak üzere ayarlanır ve 3 karakter sorulur. Unutmamak için şifreyi değiştiriniz.")."</li>
	</ul>";
	if($_POST and isset($_POST['SeCWurity_WP_Login']) and $_POST['SeCWurity_WP_Login'] == true){
		
                if(isset($_POST['sifre1'])){ $sifre1 = $_POST['sifre1']; }else{ $sifre1 = self::$sifre; }
		if(isset($_POST['sifre2'])){ $sifre2 = $_POST['sifre2']; }else{ $sifre2 = self::$sifre; }
                if(isset($_POST['k_sayi'])){ $k_sayi = $_POST['k_sayi']; }else{ $k_sayi = self::$sayi; }
                
                if(isset($_POST['d_adi'])){ $d_adi = strip_tags(htmlspecialchars(self::t_karakter_temizle($_POST['d_adi']))); }else{ $d_adi = self::$par; }
                if(isset($_POST['d_deger'])){ $d_deger = strip_tags(htmlspecialchars(self::t_karakter_temizle($_POST['d_deger']))); }else{ $d_deger = self::$deger; }
                
                $url_aktif = $_POST['url_aktif'];
                $sifre_aktif = $_POST['sifre_aktif'];
                
                ## URL KORUMA PARAMETRESİ VE DEĞERİ GÜNCELLENİYOR ##
                update_option(self::op_par, $d_adi);
                update_option(self::op_deger, $d_deger);
                
                ## EKLENTİ ÖZELLİK DURUMLARI GÜNCELLENİYOR ##
                update_option(self::op_url_durum,$url_aktif);
                update_option(self::op_login_durum,$sifre_aktif);
                
                
		if(($sifre1 == $sifre2) and !empty($sifre1) and !empty($sifre2)){
			if(!$k_sayi or !is_numeric($k_sayi)){
				print '<div class="error">'.__('Sorulmasını istediğiniz karakter sayısınız yazmalısınız.').'</div>';
			}else{
				update_option(self::op_sifre,$sifre1);
				update_option(self::op_sayi,$k_sayi);
				print '<div class="updated">'.__('Bilgiler güncellendi.').'</div> ';
			}
		}else if(empty($sifre1) and empty($sifre2)){
			$sifre1 = get_option(self::op_sifre);
			update_option(self::op_sifre,$sifre1);
			update_option(self::op_sayi,$k_sayi);
			print '<div class="updated">'.__("Bilgiler güncellendi.").'</div> ';
		}else{
			print '<div class="error">'.__('Şifreler eşleşmiyor.').'</div>';
		}
	}
print '
    <div class="cw-head">'.__("Eklenti Ayarları").' <a href="#" class="cw-toggle active"></a></div>
    <div class="cw-box">
        <label for="sifre">'.__("Güvenlik Şifresi ile Koruma").'</label>
	<select name="sifre_aktif">
            <option value="1"'.self::select_box_aktif(get_option(self::op_login_durum)).'>Aktif</option>
            <option value="0"'.self::select_box_pasif(get_option(self::op_login_durum)).'>Pasif</option>
        </select>
	<label for="k_sayi">'.__("Giriş Sayfası Url Koruması").'</label>
	<select name="url_aktif">
            <option value="1"'.self::select_box_aktif(get_option(self::op_url_durum)).'>Aktif</option>
            <option value="0"'.self::select_box_pasif(get_option(self::op_url_durum)).'>Pasif</option>
        </select>
    </div>';
    if(get_option(self::op_login_durum)){ print '<div class="cw-head">'.__("Güvenlik Şifresi Ayarları").' <a href="#" class="cw-toggle active"></a></div>
    <div class="cw-box">
        <label for="sifre">'.__("Güvenlik Şifreniz").'</label>
	<input type="password" name="sifre1" />
	<input type="password" name="sifre2" />
	<label for="k_sayi">'.__("Sorulacak Karakter Sayısı").'</label>
	<input type="number" name="k_sayi" required="required" value="'.__(self::$sayi).'" />
    </div>';
    }
    if(get_option(self::op_url_durum)){ print '<div class="cw-head">'.__("Giriş Sayfası Ayarları").' <a href="#" class="cw-toggle active"></a></div>
    <div class="cw-box">
        <label for="d_adi">'.__("Parametre Adı").'</label>
        <input type="text" name="d_adi" value="'.__(self::$par).'"/>
        <label for="d_degeri">'.__("Parametre Değeri").'</label>
        <input type="text" name="d_deger" value="'.__(self::$deger).'"/>
        <div class="link_title">'.__('Login Link').'</div>
	<div class="link">'.home_url().'/wp-login.php?'.get_option(self::op_par).'='.get_option(self::op_deger).'</div>
    </div>';
    }
        print '<input type="hidden" name="SeCWurity_WP_Login" value="1"/>
        <input type="submit" value="'.__("Save Changes").'" />
	<p class="copyright"><font color="#01DF01">CW</font>, since 2001</p>
</form>
';
?>