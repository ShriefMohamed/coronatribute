<?php


namespace Framework\controllers;


use Framework\lib\AbstractController;
use Goutte\Client;


class CronController extends AbstractController
{
    public function Load_latest_countsAction()
    {
        $url = "https://www.worldometers.info/coronavirus";

        $client = new Client();
        $crawler = $client->request('GET', $url);

        $results = $crawler->filter('div[id="maincounter-wrap"] span')->each(function ($node) {
            return $node->text();
        });

        if ($results) {
            file_put_contents(APPLICATION_DIR . 'corona_updates.txt', json_encode($results));
        }

    }
}