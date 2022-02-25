<?php

//use App\Models\AdminLump;

function localGovts($refnum)
{
    //Create LGA arrays
	$state = array(
            'Abia'=>array('Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Isuikwuato', 'Obi Ngwa', 'Ohafia', 'Osisioma Ngwa', 'Ugwunagbo', 'Ukwa East', 'Ukwa West', 'Umuahia North', 'Umuahia South', 'Umu Nneochi'),
            'Adamawa'=>array('Demsa', 'Fufore', 'Ganye', 'Girei', 'Gombi', 'Guyuk', 'Hong', 'Jada', 'Lamurde', 'Madagali', 'Maiha', 'Mayo-Belwa', 'Michika', 'Mubi North', 'Mubi South', 'Numan', 'Shelleng', 'Song', 'Toungo LGA', 'Yola North', 'Yola South'),
            'Akwa Ibom'=>array('Abak', 'Eastern Obolo', 'Eket', 'Esit-Eket', 'Essien Udim', 'Etim-Ekpo', 'Etinan', 'Ibeno', 'Ibesikpo-Asutan', 'Ibiono-Ibom', 'Ika', 'Ikono', 'Ikot Abasi', 'Ikot Ekpene', 'Ini', 'Itu', 'Mbo', 'Mkpat-Enin', 'Nsit-Atai', 'Nsit-Ibom', 'Nsit-Ubium', 'Obot-Akara', 'Okobo', 'Onna', 'Oron', 'Oruk Anam', 'Ukanafun', 'Udung-Uko', 'Uruan', 'Urue-Offong/Oruko', 'Uyo'),
            'Anambra'=>array('Aguata', 'Awka North', 'Awka South', 'Anambra East', 'Anambra West', 'Anaocha', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'),
            'Bauchi'=>array('Bauchi', 'Tafawa Balewa', 'Dass', 'Toro', 'Bogoro', 'Ningi', 'Warji', 'Ganjuwa', 'Kirfi', 'Alkaleri', 'Darazo', 'Misau', 'Giade', 'Shira', 'Jama\'\are', 'Katagum', 'Itas/Gadau', 'Zaki', 'Gamawa', 'Damban'),
            'Bayelsa'=>array('Brass', 'Ekeremor', 'Kolokuma/Opokuma', 'Nembe', 'Ogbia', 'Sagbama', 'Southern Ijaw', 'Yenagoa'),
            'Benue'=>array('Ado', 'Agatu', 'Apa', 'Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Makurdi', 'Obi', 'Ogbadibo', 'Ohimini', 'Oju', 'Okpokwu', 'Otukpo', 'Tarka', 'Ukum', 'Ushongo', 'Vandeikya'),
            'Borno'=>array('Abadan', 'Askira/Uba', 'Bama', 'Bayo', 'Biu', 'Chibok', 'Damboa', 'Dikwagubio', 'Guzamala', 'Gwoza', 'Hawul', 'Jere', 'Kaga', 'Kalka/Balge', 'Konduga', 'Kukawa', 'Kwaya-ku', 'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno', 'Ngala', 'Nganzai', 'Shani'),
            'Cross River'=>array('Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra', 'Biase', 'Boki', 'Calabar Municipal', 'Calabar South', 'Etung', 'Ikom', 'Obanliku', 'Obubra', 'Obudu', 'Odukpani', 'Ogoja', 'Yakuur', 'Yala'),
            'Delta'=>array('Aniocha South', 'Anioha', 'Bomadi', 'Burutu', 'Ethiope West', 'Ethiope East', 'Ika South', 'Ika North East', 'Isoko South', 'Isoko North', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North', 'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli south', 'Ughelli north', 'Ukwuani', 'Uviwie', 'Warri central', 'Warri north', 'Warri south'),
            'Ebonyi'=>array('Abakaliki', 'Afikpo North', 'Afikpo South (Edda)', 'Ebonyi', 'Ezza North', 'Ezza South', 'Ikwo', 'Ishielu', 'Ivo', 'Izzi', 'Ohaozara', 'Ohaukwu', 'Onicha'),
            'Edo'=>array('Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East', 'Esan West', 'Etsako Central', 'Etsako East', 'Etsako West', 'Igueben', 'Ikpoba-Okha', 'Oredo', 'Orhionmwon', 'Ovia North-East', 'Ovia South-West', 'Owan East', 'Owan West', 'Uhunmwonde'),
            'Ekiti'=>array('Ado-Ekiti', 'Ikere', 'Oye', 'Aiyekire (Gbonyin)', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West', 'Emure', 'Ido-Osi', 'Ijero', 'Ikole', 'Ilejemeje', 'Irepodun/Ifelodun', 'Ise/Orun', 'Moba'),
            'Enugu'=>array('Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South', 'Ezeagu', 'Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Isi Uzo', 'Nkanu East', 'Nkanu West', 'Nsukka', 'Oji River', 'Udenu', 'Udi', 'Uzo-Uwani'),
            'Gombe'=>array('Akko', 'Balanga', 'Billiri', 'Dukku', 'Dunakaye', 'Gombe', 'Kaltungo', 'Kwami', 'Nafada/Bajoga', 'Shomgom', 'Yamaltu/Deba'),
            'Imo'=>array('Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte Mbaise', 'Ideato Nort', 'Ideato South', 'Ihitte/Uboma', 'Ikeduru', 'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba', 'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji/Egbema', 'Okigwe', 'Onuimo', 'Orlu', 'Orsu', 'Oru East', 'Oru West', 'Owerri Municipal', 'Owerri North', 'Owerri West', 'Nwangele'),
            'Jigawa'=>array('Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kaugama', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'),
            'Kaduna'=>array('Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', 'Jema\'\a', 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'),
            'Kano'=>array('Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbtso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nassarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'),
            'Katsina'=>array('Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dan Musa', 'Dandume', 'Danja LGA', 'Daura', 'Dutsi', 'Dutsin-Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', 'Mai\'\Adua','Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'),
            'Kebbi'=>array('Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dand', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko/Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Danko/Wasagu', 'Yauri', 'Zuru'),
            'Kogi'=>array('Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela-Odolu', 'Ijumu', 'Kabba/Bunu', 'Koton Karfe', 'Lokoja', 'Mopa-Muro', 'Ofu', 'Ogori/Magongo', 'Okehi', 'Okene', 'Olamaboro', 'Omala', 'Yagba East', 'Yagba West'),
            'Kwara'=>array('Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun', 'Ilorin East', 'Ilorin South', 'Ilorin Wes', 'Irepodun', 'Isin', 'Kaiama', 'Moro', 'Offa','Oke Ero', 'Oyun', 'Pategi'),
            'Lagos'=>array('Agege', 'Alimosho Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti-Osa', 'Ibeju-Lekki', 'Ifako/Ijaye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi–Isolo', 'Shomolu', 'Surulere'),
            'Nasarawa'=>array('Akwanga', 'Awe', 'Doma', 'Karu', 'Keana', 'Keffi', 'Kokona', 'Lafia', 'Nassarawa', 'Nassarawa/Eggon','Obi', 'Toto', 'Wamba'),
            'Niger'=>array('Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso', 'Chanchaga', 'Edati', 'Gbako', 'Gurara', 'Katcha', 'Kontagora', 'Lapai', 'Lavun', 'Magama', 'Mariga','Mashegu', 'Mokwa', 'Munya', 'Paikoro', 'afi', 'Rijau', 'Shiroro', 'Suleja', 'Tafa', 'Wushishi'),
            'Ogun'=>array('Abeokuta North', 'Abeokuta South', 'Ado-Odo/Ota', 'Ewekoro', 'Ifo', 'Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Imeko Afon', 'Ipokia', 'Obafemi Owode', 'Odogbolu', 'Odeda', 'Ogun Waterside', 'Remo North', 'Sagamu', 'Yewa North', 'Yewa South'),
            'Ondo'=>array('Akoko North', 'Akoko North East', 'Akoko South East', 'Akoko South', 'Akure North', 'Akure', 'Idanre', 'Ifedore', 'Ese Odo', 'Ilaje', 'Ile Oluji/Okeigbo', 'Irele', 'Odigbo', 'Okitipupa', 'Ondo', 'Ondo East', 'Ose', 'Owo'),
            'Osun'=>array('Atakumosa Wwest', 'Atakumosa East', 'Ayedaade', 'Ayedire', 'Bolawaduro', 'Boripe', 'Ede', 'Ede North', 'Egbedore', 'Ejigbo', 'Ife North', 'Ife Central', 'Ife South', 'Ife East', 'Ifedayo', 'Ifelodun', 'Ilesha West', 'Ila-orangun', 'Ilesah East', 'Irepodun', 'Irewole', 'Isokan', 'Iwo', 'Obokun', 'Odo-otin', 'Ola Oluwa', 'Olorunda', 'Oriade', 'Orolu', 'Osogbo'),
            'Oyo'=>array('Akinyele Moniya', 'Afijio Jobele', 'Egbeda Egbeda', 'Ibadan North Agodi Gate', 'Ibadan North-East Iwo Road', 'Ibadan North-West', 'Ibadan South-West Ring Road', 'Ibadan South-East Mapo', 'Ibarapa Central', 'Ibarapa East Eruwa', 'Ido', 'Irepo', 'Iseyin', 'Kajola', 'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Oyo West Ojongbodu', 'Atiba Ofa Meta', 'Atisbo Tede', 'Saki West', 'Saki East', 'Itesiwaju Otu', 'Iwajowa', 'Ibarapa North', 'Olorunsogo', 'Oluyole', 'Ogo Oluwa', 'Surulere', 'Orelope', 'Ori Ire', 'Oyo East', 'Ona Ara'),
            'Plateau'=>array('Barkin Ladi', 'Bassa', 'Bokkos', 'Jos East', 'Jos North', 'Jos South', 'Kanam', 'Kanke', 'Langtang North', 'Langtang South', 'Mangu', 'Mikang', 'Pankshin', 'Qua\'\an Pan', 'Riyom', 'Shendam', 'Wase'),
            'Rivers'=>array('Abua-Odual', 'Ahoada East', 'Ahoada West', 'Akuku-Toru', 'Andoni', 'Asari-Toru', 'Bonny', 'Degema','Eleme', 'Emohua', 'Etche', 'Gokana', 'Ikwerre', 'Oyigbo', 'Khana', 'Obio-Akpor', 'Ogba-Egbema-Ndoni', 'Ogu-bolo', 'Okrika', 'Omumma', 'Opobo-Nkoro', 'Portharcourt', 'Tai' ),
            'Sokoto'=>array('Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamako', 'Wurno', 'Yabo'),
            'Taraba'=>array('Ardo Kola', 'Bali', 'Donga', 'Gashak', 'Gassol', 'Ibi', 'Jalingo', 'Karim Lamido', 'Kurmi', 'Lau', 'Sardauna', 'Takum', 'Ussa', 'Wukari','Yorro', 'Zing'), 
            'Yobe'=>array('Bade', 'Bursari', 'Damaturu', 'Geidam', 'Gujba', 'Gulani', 'Fika', 'Fune', 'Jakusko', 'Karasuwa', 'Machina', 'Nangere', 'Nguru', 'Potiskum', 'Tarmuwa', 'Yunusari', 'Yusufari'),  
            'Zamfara'=>array('Anka', 'Bakura', 'Birnin Magaji/Kiyaw', 'Bukkuyum', 'Bungudu', 'Tsafe', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Zurmi'),  
            'FCT'=>array('Abaji', 'Abuja', 'Municipal', 'Gwagwalada','Kuje','Bwari','Kwali')
        );
    
       //state default array
	   $lgaOptions = '<option></option>';
		
		foreach($state[$refnum] as $item){
			$lgaOptions .= '<option value="'.$item.'">'.$item.'</option>';
		}

    return $lgaOptions;
}

function emailAPI($method, $url, $data, $headers = null)
{

    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);

    if ($headers && !empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // EXECUTE:
    $result = curl_exec($curl);
    
    if (!$result) {
        //die("Connection Failure");
        return false;
    }
    curl_close($curl);
    
    return $result;
}