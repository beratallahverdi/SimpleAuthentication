<?php 
class SimpleAuthentication{
	private $pUsername = "USERNAME";
	private $pPwd = "PASSWORD";
	private $mUrl = "URL";
	private $token = "";	
	public function __construct(){
        $sorgu=http_build_query(array("pUsername"=>$this->pUsername,"pPwd"=>$this->pPwd));
		$sorgu = "?".$sorgu;
		$link = "Login";
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->mUrl.$link.$sorgu);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,60);
		$sonuc= curl_exec($ch);
		$a = json_decode($sonuc,true);
		$this->token = $a["Data"];
	}
    public function getBrands(){
	    $parametre=array();
        $sorgu=http_build_query($parametre);
		$sorgu = "?".$sorgu;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->mUrl."GetBrands".$sorgu);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('token:'.$this->token));
		$sonuc= curl_exec($ch);
		$a = json_decode($sonuc,true);

		return $a;
	}
	
    public function getProducts($marka, $tarih="19000101"){
	    $parametre=array("pBrand"=>$marka,"pTarih"=>$tarih);
		$sorgu=http_build_query($parametre);
		$sorgu = "?".$sorgu;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->mUrl."GetProducts".$sorgu);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('token:'.$this->token));
		$sonuc= curl_exec($ch);
		$a = json_decode($sonuc,true);
		return $a;
	}
	public function get($link, $parametre = array()){
		$parametre = $this->preLink($link,$parametre);
		$sorgu=http_build_query($parametre);
		$sorgu = "?".$sorgu;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->mUrl.$link.$sorgu);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('token:'.$this->token));
		$sonuc= curl_exec($ch);
		$a = json_decode($sonuc,true);
		return ($a["Result"]["message"])?$a["Result"]["message"]:$a["Data"];
	}
	private function preLink($l, $p = array()){
		switch($l){
			case "GetProducts": $r = (isset($p["pBrand"]) && isset($p["pTarih"]))? $p :((isset($p["pBrand"])) ? array("pBrand"=>$p["pBrand"],"pTarih"=>"19000101"): array("pBrand"=>"","pTarih"=>"19000101")); print_r(array_keys($r)); break;
			case "StokSorgula": $r = (isset($p["stokKodu"]) && isset($p["netsisStokId"]) && isset($p["adet"]))? $p : array("stokKodu"=>"","netsisStokId"=>"","adet"=>""); print_r(array_keys($r)); break;
			case "Login": $r = (isset($p["pUsername"]) && isset($p["pPwd"]))? $p : array("pUsername"=>"Username","pPwd"=>"Password"); print_r(array_keys($r)); break;
			case "KategoriUrunListesi": $r = (isset($p["kategori1"]))? $p : array("kategori1"=>""); print_r(array_keys($r)); break;
			case "AracMarkaUrunListesi": $r = (isset($p["aracMarka"]))? $p : array("aracMarka"=>""); print_r(array_keys($r)); break;
			case "GetStockByCode": $r = (isset($p["pProductCode"]))? $p : array("pProductCode"=>""); print_r(array_keys($r)); break;
			case "GetStockByDate": $r = (isset($p["pTarih"]))? $p : array("pTarih"=>"19000101"); print_r(array_keys($r)); break;
			case "GetStockId": $r = (isset($p["pStokId"]))? $p : array("pStokId"=>""); print_r(array_keys($r)); break;
			case "Kategoriler": $r = array(); break;
			case "AracMarka": $r = array(); break;
			case "GetCurrency": $r = array(); break;
			case "GetBrands": $r = array(); break;
			default: $r = array(); break;
		}
		return $r;
	}
}
?>