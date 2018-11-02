<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$jsonKota = $this->getKota();
		$dataKota = json_decode($jsonKota,true);
		$dataKota = $dataKota['rajaongkir']['results'];
		$data['dataKota'] = $dataKota;

		if(isset($_POST['input'])){
			$kota = $_POST['kota'];
			$berat = $_POST['berat'];
			$kurir = $_POST['kurir'];
			$cost = $this->postCost("39",$kota,$berat,$kurir);
			$cost = json_decode($cost,true);
			$cost = $cost['rajaongkir'];

			echo "status : ".$cost['status']['code']." - ".$cost['status']['description'];
			echo "<br>";
			foreach ($cost['results'] as $value){
				echo "kurir : ".$value['name'];
				echo "<br>";
				if(count($value['costs'])>0){
					foreach ($value['costs'] as $item){
						echo "cost : ".$item;
					}
				}
				else{
					echo "harga tidak dapat diambil";
				}

			}
		}

		$this->load->view('welcome_message',$data);
	}

	var $key = 'b0dbfa4c10c19d5e0f9f01731b2614e5';

	function postCost($origin="",$destination="",$weight="",$courier=""){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=".$courier."",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: $this->key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}

	function getKota(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: $this->key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}
}
