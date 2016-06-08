<?php
class robots_txt extends Engine_Class {

    public function process() {
        $robots = PackageLoader::Get()->getProjectPath().'robots.txt';

        header('Content-type: text/plain');
        // тестовый сайт
        $projectTest = Engine::Get()->getConfigField('project-test');
        if ($projectTest) {
            echo "User-agent: *\n";
            echo "Disallow: /\n";
            exit();
        }

        // показываем robots.txt если он есть
        if (file_exists($robots)) {
            $robots = file_get_contents($robots);
            if ($robots) {
                echo $robots;
                exit();
            }
        }

        echo "User-agent: *\n";
        echo "Disallow: /*currency*\n";
        echo "Disallow: /*.php$\n";
        echo "Disallow: /*p=0*\n";
        echo "Disallow: /*/p-*\n";
        echo "Disallow: /*p=all*\n";
        echo "Disallow: /*show=table*\n";
        echo "Disallow: /*buy=*\n";
        echo "Disallow: /*show=thumbs*\n";
        echo "Disallow: /*brand=*brand=*\n";
        echo "Disallow: /*category=*category=*\n";
        echo "Disallow: /*category=*brand=*\n";
        echo "Disallow: /*brand=*category=*\n";
        echo "Disallow: /*filter*=*filter*=*\n";
        echo "Disallow: /*query=*\n";
        echo "Disallow: /client/*\n";
        echo "Disallow: /admin/*\n";
        echo "Disallow: /search/*\n";
        echo "Sitemap: ".Engine::Get()->getProjectURL()."/sitemap.xml\n";
        echo "Host: ".Engine::Get()->getProjectHost()."\n";

        exit();
    }

}