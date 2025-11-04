<?php

namespace SH\Service;

class BulletinService
{

    // Define category Icons
    private function findUnicodeById($jsonData, $id)
    {
        foreach ($jsonData as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null; // Retorna null se não encontrar o id
    }

    // Prepare bulletin array
    private function populateArray($posts, $emojis)
    {
        $array = [];
        foreach ($posts as $p) {
            $cat = $p['categories'][0];
            $emojiObj = $this->findUnicodeById($emojis, $cat);
            $category = $emojiObj['name'] == null ? "Especial" : $emojiObj['name'];
            $emoji = $emojiObj['unicode'] == null ? "\\u{1F534}" : $emojiObj['unicode'];

            $link = $p['link'] . '?utm_source=whatsapp&utm_medium=boletin';
            $bitUrl = 'https://bit.litci.org/src/Api/CreateLink.php';
            $data = ['url' => $link];
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];
            $context = stream_context_create($options);
            $result = json_decode(file_get_contents($bitUrl, false, $context), TRUE);
            $shortlink = $result['shortlink'];

            $post = [];
            $post['emoji'] = $emoji;
            $post['category'] = $category;
            $post['title'] = $p['title']['rendered'];
            $post['link'] = $shortlink;

            array_push($array, $post);
        }

        return $array;
    }

    // Get Spanhish Bulletin
    public function getBulletinEs($method)
    {

        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?order_by=menu_order&categories=17819&per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?per_page=5';
        }

        if ($method == 'lastten') {
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?per_page=10';
        }

        if ($method == 'lasttwenty') {
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?after=' . $date;
        }

        if ($method == 'palestine') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/es/wp-json/wp/v2/posts?after=' . $date . '&categories=18309&order_by=menu_order';
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    // Get Portuguese Bulletin
    public function getBulletinPt($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-pt.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?order_by=menu_order&categories=8308&per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?after=' . $date;
        }

        if ($method == 'palestine') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/pt/wp-json/wp/v2/posts?after=' . $date . '&categories=8068&order_by=menu_order';
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    public function getBulletinEn($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-pt.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?order_by=menu_order&categories=8308&per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?after=' . $date;
        }

        if ($method == 'palestine') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://litci.org/en/wp-json/wp/v2/posts?after=' . $date . '&categories=8068&order_by=menu_order';
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    // Get Costa Rica Bulletin
    public function getBulletinCostaRica($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://ptcostarica.org/index.php?rest_route=/wp/v2/posts&per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://ptcostarica.org/index.php?rest_route=/wp/v2/posts&per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://ptcostarica.org/index.php?rest_route=/wp/v2/posts&per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://ptcostarica.org/index.php?rest_route=/wp/v2/posts&per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://ptcostarica.org/index.php?rest_route=/wp/v2/posts&after=' . $date;
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    public function getBulletinColombia($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://www.magazine.pstcolombia.org/wp-json/wp/v2/posts?per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://www.magazine.pstcolombia.org/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://www.magazine.pstcolombia.org/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://www.magazine.pstcolombia.org/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://www.magazine.pstcolombia.org/wp-json/wp/v2/posts?after=' . $date;
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }
    public function getBulletinArgentina($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://pstu.com.ar/wp-json/wp/v2/posts?per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://pstu.com.ar/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://pstu.com.ar/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://pstu.com.ar/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://pstu.com.ar/wp-json/wp/v2/posts?after=' . $date;
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    public function getBulletinChile($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://www.vozdelostrabajadores.cl/wp-json/wp/v2/posts?per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://www.vozdelostrabajadores.cl/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://www.vozdelostrabajadores.cl/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://www.vozdelostrabajadores.cl/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://www.vozdelostrabajadores.cl/wp-json/wp/v2/posts?after=' . $date;
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }

    public function getBulletinSpain($method)
    {
        $emojis = json_decode(file_get_contents('https://litci.org/assets/json/emojis-es.json'), TRUE);
        $bulletin = [];

        if ($method == 'priority') {
            $url = 'https://www.corrienteroja.net/wp-json/wp/v2/posts?per_page=5';
        }

        if ($method == 'lastfive') {
            $url = 'https://www.corrienteroja.net/wp-json/wp/v2/posts?per_page=5';
        }
        if ($method == 'lastten') {
            $url = 'https://www.corrienteroja.net/wp-json/wp/v2/posts?per_page=10';
        }
        if ($method == 'lasttwenty') {
            $url = 'https://www.corrienteroja.net/wp-json/wp/v2/posts?per_page=20';
        }

        if ($method == 'lastweek') {
            $date = date('Y-m-d\TH:i:s', strtotime('-7 days'));
            $url = 'https://www.corrienteroja.net/wp-json/wp/v2/posts?after=' . $date;
        }

        $json = file_get_contents($url);
        $posts = json_decode($json, TRUE);
        $bulletin = $this->populateArray($posts, $emojis);

        $result = json_encode($bulletin);
        return $result;
    }
}
