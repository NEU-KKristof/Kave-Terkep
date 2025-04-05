<?php

session_start();

// Ezek a változók használhatók lennének, ha lenne bejelentkezés/kijelentkezés a főoldalon,
// de mivel a navbar lekerül, itt most nincs közvetlen hasznuk, meghagyhatók későbbre.
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$username = $is_logged_in ? htmlspecialchars($_SESSION["username"]) : '';
$email = $is_logged_in ? htmlspecialchars($_SESSION["email"]) : '';

?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kávé világ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5e8d3, #ffffff);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .leaflet-popup-content-wrapper {
            background-color: #4a2c2a;
            color: #f5f0e1;
            border-radius: 0.5rem;
        }

        .leaflet-popup-content {
            margin: 10px;
        }

        .leaflet-popup-tip-container {
            display: none;
        }

        .coffee-icon {
            background-color: #6f4e37;
            border: 2px solid #4a2c2a;
            border-radius: 50%;
            width: 15px !important;
            height: 15px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-left: -7.5px !important;
            margin-top: -7.5px !important;
        }

        #continent-indicator {
            border-radius: 0.375rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            text-align: center;
            font-weight: 600;
            color: white;
            transition-property: background-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        footer {
            background: linear-gradient(to right, #3c2f2f, #6b4e31);
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
            margin-top: auto;
        }

        #preloader {
            position: fixed;
            inset: 0;
            background-color: #f5e8d3;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        #preloader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #preloader-bean {
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #region-info {
            transition: opacity 0.3s ease-in-out;
        }

        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-animate {
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }

        .tartalom {
            width: 75%;
        }
    </style>
</head>

<body>

    <?php
    include 'navbar.php';
    ?>

    <div id="preloader">
        <img id="preloader-bean" src="../img/coffeebean_icon.png" alt="[Töltő kávébab ikon]">
    </div>

    <center>
        <div class="tartalom">
            <h1 class="text-3xl font-bold text-center text-[#4a2c2a] mb-8">Fedezd fel a Kávé Világát!</h1>

            <div id="map"></div>

            <div id="continent-indicator" class="bg-gray-500">
            </div>

            <div id="region-info" class="bg-white p-6 rounded-lg shadow-lg min-h-[300px] border border-[#dcd0c0] mt-4">
                <h2 id="region-title" class="text-2xl font-bold text-[#6f4e37] mb-4">Válassz egy régiót a térképen!</h2>
                <div id="region-content" class="text-[#4a2c2a] space-y-4">
                    <p id="region-description">Kattints egy jelölőre a térképen, hogy többet megtudj az adott kávétermesztő vidékről, jellegzetes kávéfajtáiról és termesztési módszereiről.</p>
                    <img id="region-image" src="https://placehold.co/600x400/f5f0e1/4a2c2a?text=K%C3%A1v%C3%A9r%C3%A9gi%C3%B3+K%C3%A9pe" alt="[Kép a kávé régióról]" class="w-full h-auto max-w-md mx-auto rounded-lg object-cover hidden">
                    <div id="region-details" class="hidden">
                        <h3 class="text-lg font-semibold mt-4">Jellemző kávéfajták:</h3>
                        <p id="region-varieties"></p>
                        <h3 class="text-lg font-semibold mt-4">Termesztési módszerek:</h3>
                        <p id="region-methods"></p>
                    </div>
                </div>
            </div>
        </div>
    </center>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Kávé világ - Footer</p>
    </footer>

    <script>
        window.onload = function() {
            const preloader = document.getElementById('preloader');
            const mapElement = document.getElementById('map');

            if (preloader) {
                preloader.classList.add('hidden');
                setTimeout(() => {
                    if (preloader.parentNode) {
                        preloader.style.display = 'none';
                    }
                }, 500);
            }

            if (typeof L !== 'undefined' && mapElement) {
                initializeMapAndMarkers();
            } else {
                console.error("Leaflet library or map container not found.");
            }
        };

        function initializeMapAndMarkers() {
            const map = L.map('map').setView([0, 0], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            //-- Adatok az elemekről objektumba
            const coffeeRegions = [
                // Dél-Amerika
                {
                    name: "Brazília (Minas Gerais)",
                    continent: "Dél-Amerika",
                    coords: [-18.5122, -44.5550],
                    description: "A világ vitathatatlanul legnagyobb kávétermelője, Brazília adja a globális termelés jelentős részét. Minas Gerais állam a szívében fekszik ennek a hatalmas termelésnek. A brazil kávék általában alacsony savtartalmúak, testesek, és gyakran diós, csokoládés, karamellás ízjegyekkel rendelkeznek, így kiváló alapot adnak keverékekhez.",
                    image: "../img/Bourbon.jpg",
                    varieties: "Bourbon (Red, Yellow), Typica, Caturra, Catuaí, Mundo Novo, Acaiá",
                    methods: "Túlnyomórészt száraz (natural) feldolgozás a napon, de egyre gyakoribb a félig mosott (pulped natural) és mosott (washed) eljárás is a specialty szektorban."
                },
                {
                    name: "Kolumbia (Antioquia)",
                    continent: "Dél-Amerika",
                    coords: [6.2442, -75.5812],
                    description: "Kolumbia a magas minőségű Arabica szinonimája. Az Andok meredek lejtőin, vulkanikus talajon termesztett kávé híres kiegyensúlyozottságáról, közepes testességéről és élénk, de kellemes savasságáról. Antioquia régiója az ország egyik legnagyobb termelője, változatos mikroklímával. Ízében gyakran felfedezhetőek gyümölcsös, karamellás vagy diós jegyek.",
                    image: "../img/castillo.webp",
                    varieties: "Typica, Bourbon, Caturra, Castillo (rozsda-rezisztens hibrid), Colombia",
                    methods: "Szinte kizárólag mosott (washed) feldolgozás, amely tiszta, élénk ízprofilt eredményez. A 'Supremo' és 'Excelso' a szemméret szerinti osztályozásra utal."
                },
                 {
                    name: "Peru (Chanchamayo)",
                    continent: "Dél-Amerika",
                    coords: [-11.1589, -75.3333],
                    description: "Peru csendesen vált a specialty kávé világának egyik fontos szereplőjévé, különösen az organikus és fair trade minősítésű kávék terén. A Chanchamayo völgy az ország központi részén található, magas fekvésű területein kiváló Arabica terem. A perui kávék általában lágyak, enyhén savasak, közepesen testesek, édes, diós, csokoládés és néha finoman virágos aromákkal.",
                    image: "../img/Bourbon.jpg",
                    varieties: "Typica, Caturra, Bourbon, Pache",
                    methods: "Főleg mosott (washed) feldolgozás. Sok kistermelő szövetkezetekbe tömörül a jobb minőség és értékesítés érdekében."
                },
                // Afrika
                {
                    name: "Etiópia (Yirgacheffe)",
                    continent: "Afrika",
                    coords: [6.1630, 38.2065],
                    description: "Etiópia az Arabica kávé bölcsője, a legenda szerint itt fedezték fel a kávé élénkítő hatását. Yirgacheffe egy kis, de világhírű régió délen, amely rendkívül jellegzetes, komplex kávékat ad. A mosott Yirgacheffe kávék híresek virágos (jázmin), citrusos (citrom, bergamott) aromáikról és tea-szerű testességükről. A száraz eljárásúak intenzíven gyümölcsösek, áfonyás, boros jegyekkel.",
                    image: "../img/heirloom.jpg",
                    varieties: "Őshonos ('Heirloom') etióp fajták (pl. Kurume, Dega, Wolisho)",
                    methods: "Mind a mosott (washed), mind a száraz (natural) feldolgozás elterjedt és nagyra értékelt, mindkettő egyedi ízprofilt eredményez."
                },
                {
                    name: "Kenya (Nyeri)",
                    continent: "Afrika",
                    coords: [-0.4220, 36.9520],
                    description: "A kenyai kávékat gyakran a világ legjobbjai között tartják számon, köszönhetően egyedi és intenzív ízviláguknak. Nyeri megye a Kenya-hegy lábánál fekszik, gazdag vulkanikus talajjal. Az itteni kávékra jellemző a vibráló, komplex savasság (gyakran paradicsomos vagy feketeribizlis), a telt test és a boros, gyümölcsös édesség. A kenyai kávé feldolgozása rendkívül aprólékos.",
                    image: "../img/ruiro 11.webp",
                    varieties: "SL-28, SL-34 (Bourbon-leszármazottak, kiváló ízminőség), Ruiru 11, Batian (újabb, betegségellenálló fajták)",
                    methods: "Szinte kizárólag dupla mosott (double washed) feldolgozás, amely hozzájárul a tiszta, fényes ízprofilhoz. Az értékesítés gyakran aukciós rendszeren keresztül történik."
                },
                 {
                    name: "Uganda (Mount Elgon)",
                    continent: "Afrika",
                    coords: [1.1333, 34.5333],
                    description: "Uganda elsősorban Robusta termeléséről ismert, de az ország keleti részén, a Kenya határán átnyúló Mount Elgon vulkán lejtőin kiváló minőségű Arabica is terem. Az itteni Arabica kávék gyakran hasonlítanak a kenyaiakhoz, de általában lágyabb savakkal és inkább boros, gyümölcsös jegyekkel rendelkeznek. A DRUGAR (Dry Ugandan Arabica) egy alacsonyabb minőségű, szárazon feldolgozott változat.",
                    image: "../img/green-coffee-beans.jpg",
                    varieties: "Arabica (Typica, SL-14, SL-28, Nyasaland), Robusta (Nganda, Erecta)",
                    methods: "Arabica esetében főleg mosott (WUGAR - Washed Ugandan Arabica), Robusta esetében túlnyomórészt száraz feldolgozás."
                },
                // Ázsia
                {
                    name: "Vietnám (Dak Lak)",
                    continent: "Ázsia",
                    coords: [12.6667, 108.0000],
                    description: "Vietnám Brazília után a világ második legnagyobb kávéexportőre, termelésének túlnyomó többségét a Robusta teszi ki. Dak Lak provincia a Központi-felföldön az ország fő kávétermesztő központja. A vietnámi Robusta erős, testes, magas koffeintartalmú, ízében gyakran kesernyés, gumis vagy csokoládés jegyekkel. Fontos összetevője espresso keverékeknek és a híres vietnámi jeges kávénak (ca phe sua da).",
                    image: "../img/robusta.jpg",
                    varieties: "Robusta (főleg)",
                    methods: "Túlnyomórészt száraz (natural) feldolgozás, de a mosott eljárás is terjedőben van a minőség javítása érdekében."
                },
                {
                    name: "Indonézia (Szumátra - Mandheling)",
                    continent: "Ázsia",
                    coords: [1.6000, 99.2500], // Mandheling egy tágabb régió/kereskedelmi név
                    description: "Indonézia szigetei változatos kávékat kínálnak. Szumátra különösen híres a 'Giling Basah' (wet-hulled) nevű egyedi feldolgozási módszeréről, amely nedvesen hántolt kávét jelent. Ez testes, szirupos textúrát, alacsony savtartalmat, valamint jellegzetes földes, dohányos, fűszeres, néha gyógynövényes ízjegyeket eredményez. A 'Mandheling' egy kereskedelmi név, amelyet gyakran a Batak népcsoport által termesztett minőségi szumátrai kávékra használnak.",
                    image: "../img/catimor.jpg",
                    varieties: "Typica, Catimor, Linie S, Tim Tim, Ateng",
                    methods: "Legjellemzőbb a Giling Basah (wet-hulled), de mosott és száraz eljárásokat is alkalmaznak más szigeteken (pl. Jáva, Sulawesi)."
                },
                {
                    name: "India (Karnataka)",
                    continent: "Ázsia",
                    coords: [13.0000, 76.0000],
                    description: "India gazdag kávétörténelemmel rendelkezik, és mind Arabica, mind Robusta fajtákat termesztenek, gyakran fűszernövények (pl. kardamom, vanília) árnyékában. Karnataka állam az ország fő termőterülete (Chikmagalur, Coorg régiók). Az indiai kávék általában testesek, közepes vagy alacsony savtartalmúak. Különlegességük a 'Monsooned Malabar', ahol a nyers kávét a monszun szeleknek teszik ki, ami megduzzasztja a szemeket és egyedi, savszegény, dohányos, földes ízt eredményez.",
                    image: "../img/Selection 9.webp",
                    varieties: "Kent, S.795 (népszerű Arabica), Cauvery (Catimor-leszármazott), Selection 9, Robusta (CxR)",
                    methods: "Mosott és száraz feldolgozás egyaránt elterjedt, valamint a speciális 'Monsooning' eljárás."
                }
            ];

            const regionInfoDiv = document.getElementById('region-info');
            const regionTitle = document.getElementById('region-title');
            const regionDescription = document.getElementById('region-description');
            const regionImage = document.getElementById('region-image');
            const regionDetails = document.getElementById('region-details');
            const regionVarieties = document.getElementById('region-varieties');
            const regionMethods = document.getElementById('region-methods');
            const continentIndicator = document.getElementById('continent-indicator');

            function updateRegionInfo(region) {
                if (!regionInfoDiv) return;

                regionTitle.textContent = region.name;
                regionDescription.textContent = region.description;
                regionImage.src = region.image;
                regionImage.alt = `[Kép a következő régióról: ${region.name}]`;
                regionImage.classList.remove('hidden');
                regionVarieties.textContent = region.varieties;
                regionMethods.textContent = region.methods;
                regionDetails.classList.remove('hidden');
                continentIndicator.textContent = region.continent;

                // Szin szerint változó sáv
                continentIndicator.classList.remove('bg-gray-500', 'bg-green-800', 'bg-amber-800', 'bg-yellow-600');
                switch (region.continent) {
                    case 'Dél-Amerika':
                        continentIndicator.classList.add('bg-green-800');
                        break;
                    case 'Afrika':
                        continentIndicator.classList.add('bg-amber-800');
                        break;
                    case 'Ázsia':
                        continentIndicator.classList.add('bg-yellow-600');
                        break;
                    default:
                        continentIndicator.classList.add('bg-gray-500');
                }

                // Apply animation to the region info container
                regionInfoDiv.classList.remove('content-animate');
                void regionInfoDiv.offsetWidth;
                regionInfoDiv.classList.add('content-animate');
            }

            // --- Add Markers to Map ---
            coffeeRegions.forEach(region => {
                const coffeeIcon = L.divIcon({
                    className: 'coffee-icon',
                    iconSize: [15, 15]
                });
                const marker = L.marker(region.coords, {
                    icon: coffeeIcon
                }).addTo(map);
                marker.on('click', () => {
                    updateRegionInfo(region);
                    map.flyTo(region.coords, 6);

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 400);
                });
            });
        } // End of initializeMapAndMarkers function

        window.onload = function() {
            const preloader = document.getElementById('preloader');
            const mapElement = document.getElementById('map');

            const extraVisibleTime = 2000; // 2s animáció

            setTimeout(() => {
                if (preloader) {
                    // Elhalványítás indítása a 'hidden' osztály hozzáadásával
                    preloader.classList.add('hidden');
                    // Eltávolítás/elrejtés a halványítási animáció (0.5s) után
                    setTimeout(() => {
                        if (preloader.parentNode) {
                            preloader.style.display = 'none'; // Elrejtés
                        }
                    }, 500);
                }
            }, extraVisibleTime); // Itt alkalmazzuk a beállított késleltetést

            if (typeof L !== 'undefined' && mapElement) {
                initializeMapAndMarkers();
            } else {
                console.error("Leaflet library or map container not found.");
            }
        };
    </script>
</body>
</html>