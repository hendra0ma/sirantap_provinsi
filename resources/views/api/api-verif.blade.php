<?php 
use Illuminate\Support\Facades\Cache;

$config = App\Models\Config::first();
$kotas = App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
    ->where('regencies.province_id', $config->provinces_id)
    ->get();

$client = new GuzzleHttp\Client();
$dataApi = [];
$i = 0;
foreach ($kotas as $hehe) : 
    $url = "https://".$hehe->domain."/api/public/get-voice?jenis=terverifikasi";
    $voices = Cache::get($url, function () use ($client, $url) {
        $response = $client->request('GET', $url, ['headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],]);
        $voices = json_decode($response->getBody());
        Cache::put($url, $voices, 60);
        return $voices;
    });
    array_push($dataApi, $voices);
?>
<tr>
    <th scope="row"> 
        <a href="https://{{$hehe->domain}}/ceksetup">
            <?= $hehe->name  ?>
        </a>      
    </th>
    @foreach($voices as $vcs)
    <td>{{$vcs->voice}}</td>
    @endforeach
</tr>
<?php endforeach; ?>
                                
           