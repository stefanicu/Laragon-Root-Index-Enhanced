<?php
      if (!empty($_GET['q'])) {
            switch ($_GET['q']) {
                  case 'info':
                        phpinfo();
                        exit;
                  break;
            }
      }


    $dirs = array_filter(glob('*'), 'is_dir');
    asort($dirs);
    $i = 1;
    $cnt = count($dirs);

    $array = [];

    foreach ($dirs as $dir) {
        if (substr($dir, 0, 2) != '__') {
            $array[$i] = [];

            $tech = '';
            $subdirs = array_filter(glob("$dir/*"), 'is_dir');

            $ss = 1;
            foreach ($subdirs as $subdir) {
                if (strpos($subdir, '/wp-') > 0) {
                    $tech = 'wordpress';
                    break;
                }
                $ss++;
            }

            $link = '//' . $_SERVER['HTTP_HOST'] . '/' . $dir . '/';
            $array[$i]['id'] = $i;
            $array[$i]['name'] = strtolower($dir);
            $array[$i]['link'] = $link;
            $array[$i]['group'] = 'new';
            $array[$i]['order'] = $i;
            $array[$i]['tech'] = $tech;
            $array[$i]['original_name'] = $dir;
            $i++;
        }
    }

    // encode array to json
    $json = json_encode($array);

    //write json to file
    if (!file_put_contents("data.json", $json)) {
        echo "<div class='text-4xl text-red-500'>JSON update error...</div>";
        die();
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laragon</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-zinc-100">
        <div class="max-w-7xl mx-auto items-center flex flex-col">
            <div class="grid grid-cols-2 gap-1 p-10 bg-white border rounded-xl shadow-lg w-full my-10">
                <div class="flex flex-row items-end" title="Laragon">
                    <h1 class="text-6xl font-bold p-2">Laragon</h1>
                    <a class="text-orange-600 hover:underline hover:decoration font-semibold py-2 inline-block align-text-bottom" title="Getting Started" href="https://laragon.org/docs" target="_blank">.DOC</a>
                </div>
     
                <div class="flex flex-col items-end">
                    <div><?php print($_SERVER['SERVER_SOFTWARE']); ?></div>
                    <div>PHP version: <?php print phpversion(); ?>   <span><a class="text-orange-600 hover:underline hover:decoration font-semibold" title="phpinfo()" href="/?q=info" target="_blank">info</a></span></div>
                    <div>Document Root: <?php print ($_SERVER['DOCUMENT_ROOT']); ?></div>
                </div>
            </div>

            <div x-data="collection" x-init="getRecords()" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 grid-flow-cols p-10 bg-white border rounded-xl shadow-lg w-full break-normal">
                <template x-for="(item,index) in siteuri" :key="item.id">
                    <div class="flex items-center justify-between rounded-lg shadow hover:bg-indigo-100 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-105 ">
                        <a class="rounded-lg py-4 px-6 w-full block text-orange-600 hover:text-black font-semibold break-normal" target="_blank" x-bind:href="item.link" x-text="item.name"></a>

                        <svg class="w-12 h-12" :class="{ 'hidden': item.tech !== 'wordpress' }" viewBox="0 0 560 400">
                            <g fill="#21759b" fill-rule="nonzero" transform="matrix(2.44844 0 0 2.44844 130 50.0049)">
                                <path d="m8.708 61.26c0 20.802 12.089 38.779 29.619 47.298l-25.069-68.686c-2.916 6.536-4.55 13.769-4.55 21.388z"/>
                                <path d="m96.74 58.608c0-6.495-2.333-10.993-4.334-14.494-2.664-4.329-5.161-7.995-5.161-12.324 0-4.831 3.664-9.328 8.825-9.328.233 0 .454.029.681.042-9.35-8.566-21.807-13.796-35.489-13.796-18.36 0-34.513 9.42-43.91 23.688 1.233.037 2.395.063 3.382.063 5.497 0 14.006-.667 14.006-.667 2.833-.167 3.167 3.994.337 4.329 0 0-2.847.335-6.015.501l19.138 56.925 11.501-34.493-8.188-22.434c-2.83-.166-5.511-.501-5.511-.501-2.832-.166-2.5-4.496.332-4.329 0 0 8.679.667 13.843.667 5.496 0 14.006-.667 14.006-.667 2.835-.167 3.168 3.994.337 4.329 0 0-2.853.335-6.015.501l18.992 56.494 5.242-17.517c2.272-7.269 4.001-12.49 4.001-16.989z"/>
                                <path d="m62.184 65.857-15.768 45.819c4.708 1.384 9.687 2.141 14.846 2.141 6.12 0 11.989-1.058 17.452-2.979-.141-.225-.269-.464-.374-.724z"/>
                                <path d="m107.376 36.046c.226 1.674.354 3.471.354 5.404 0 5.333-.996 11.328-3.996 18.824l-16.053 46.413c15.624-9.111 26.133-26.038 26.133-45.426.001-9.137-2.333-17.729-6.438-25.215z"/>
                                <path d="m61.262 0c-33.779 0-61.262 27.481-61.262 61.26 0 33.783 27.483 61.263 61.262 61.263 33.778 0 61.265-27.48 61.265-61.263-.001-33.779-27.487-61.26-61.265-61.26zm0 119.715c-32.23 0-58.453-26.223-58.453-58.455 0-32.23 26.222-58.451 58.453-58.451 32.229 0 58.45 26.221 58.45 58.451 0 32.232-26.221 58.455-58.45 58.455z"/>
                            </g>
                        </svg>
                        <svg class="w-12 h-12 p-3 fill-orange-600" :class="{ 'hidden': item.tech === 'wordpress' }" viewBox="0 0 93.936 93.936" xml:space="preserve">
                            <g>
                                <path d="M80.179,13.758c-18.342-18.342-48.08-18.342-66.422,0c-18.342,18.341-18.342,48.08,0,66.421
                                    c18.342,18.342,48.08,18.342,66.422,0C98.521,61.837,98.521,32.099,80.179,13.758z M44.144,83.117
                                    c-4.057,0-7.001-3.071-7.001-7.305c0-4.291,2.987-7.404,7.102-7.404c4.123,0,7.001,3.044,7.001,7.404
                                    C51.246,80.113,48.326,83.117,44.144,83.117z M54.73,44.921c-4.15,4.905-5.796,9.117-5.503,14.088l0.097,2.495
                                    c0.011,0.062,0.017,0.125,0.017,0.188c0,0.58-0.47,1.051-1.05,1.051c-0.004-0.001-0.008-0.001-0.012,0h-7.867
                                    c-0.549,0-1.005-0.423-1.047-0.97l-0.202-2.623c-0.676-6.082,1.508-12.218,6.494-18.202c4.319-5.087,6.816-8.865,6.816-13.145
                                    c0-4.829-3.036-7.536-8.548-7.624c-3.403,0-7.242,1.171-9.534,2.913c-0.264,0.201-0.607,0.264-0.925,0.173
                                    s-0.575-0.327-0.693-0.636l-2.42-6.354c-0.169-0.442-0.02-0.943,0.364-1.224c3.538-2.573,9.441-4.235,15.041-4.235
                                    c12.36,0,17.894,7.975,17.894,15.877C63.652,33.765,59.785,38.919,54.73,44.921z"/>
                            </g>
                        </svg>
                    </div>
                </template>
            </div>

        </div>
    </body>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('collection', () => ({
                openCardList: true,
                siteuri: [],
                filters: {
                    group: [],
                },

                async getRecords() {

                    this.siteuri = await (await fetch('data.json')).json()
                }
            }));
        });

        console.dir(<?= $json; ?>);
    </script>

</html>

