<?php 
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\RequestException;

$config = App\Models\Config::first();
$kotas = App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
    ->where('regencies.province_id', $config->provinces_id)
    ->get();

$client = new GuzzleHttp\Client();
$dataApi = [];
$i = 0;
foreach ($kotas as $hehe) : 
    $url = "https://".$hehe->domain."/api/public/get-voice?jenis=suara_masuk";

    $voices = Cache::get($url, function () use ($client, $url) {
     try{
        $response = $client->request('GET', $url, [
            'headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],
        ]);

        $voices = json_decode($response->getBody());
       if($response->getStatusCode() != 200){
        $voices = "";
       }
        Cache::put($url, $voices, 60);
        return $voices;
    }catch(RequestException $e){
        $voices = "";
        Cache::put($url, $voices, 60);
        return $voices;
    }
    });
    array_push($dataApi, $voices);
?>
<tr>
    <th scope="row"> 
        <a href="https://{{$hehe->domain}}/ceksetup">
            <?= $hehe->name  ?>
        </a>      
    </th>
    @if($voices == "")
    @else
    @foreach($voices as $vcs)
    <td>{{$vcs->voice}}</td>
    @endforeach
    @endif
   
</tr>
<?php endforeach; ?>
                                 
           