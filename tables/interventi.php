
<?php
#session_start();
#require('../validate_input.php');

$test=$_GET["m"];
if ($test=='test') {
    require ('../conn_test.php');
} else {
    require ('../conn.php');
}
//echo "OK";



if(!$conn) {
    die('Connessione fallita !<br />');
} else {
    $query="select id, tipo_intervento, 
    stato_intervento, data_creazione, 
    elemento_id, 
    piazzola_id,
    utente,
    priorita,
    desc_intervento,
    sum(volume) as volume, 
    string_agg(distinct rifiuto, ',') as rifiuto
    from 
    (
    select i.id,
    string_agg(ti.descrizione, ',') as tipo_intervento,
    tsi.id as id_stato_intervento,
    tsi.descrizione as stato_intervento,
    i.data_creazione, 
    i.elemento_id, 
    i.piazzola_id,
    i.utente,
    tp.descrizione as priorita,
    i.descrizione as desc_intervento,
    te.volume, 
    tr.nome as rifiuto
    from gestione_oggetti.intervento i 
    join (select a.intervento_id, b.tipo_stato_intervento_id as stato_corrente  
    from (select intervento_id, max(data_ora) as data_ora 
    from gestione_oggetti.intervento_tipo_stato_intervento 
    group by intervento_id) a
    join gestione_oggetti.intervento_tipo_stato_intervento b on a.intervento_id= b.intervento_id and a.data_ora= b.data_ora ) si on i.id = si.intervento_id 
    join gestione_oggetti.tipo_stato_intervento tsi on si.stato_corrente = tsi.id
    JOIN gestione_oggetti.intervento_tipo_intervento iti on iti.intervento_id = i.id 
    JOIN gestione_oggetti.tipo_intervento ti on ti.id = iti.tipo_intervento_id 
    join gestione_oggetti.tipo_priorita tp on i.tipo_priorita_id = tp.id 
    JOIN elem.elementi e2 on e2.id_elemento = i.elemento_id
    JOIN elem.tipi_elemento te on te.tipo_elemento = e2.tipo_elemento 
    join elem.tipi_rifiuto tr on tr.tipo_rifiuto = te.tipo_rifiuto 
    JOIN elem.piazzole p on p.id_piazzola =i.piazzola_id 
    JOIN elem.aste a on a.id_asta = p.id_asta
    JOIN topo.vie v on a.id_via = v.id_via
    JOIN topo.comuni c on c.id_comune = v.id_comune
    JOIN topo.ut u on a.id_ut = u.id_ut
    JOIN topo.quartieri q on q.id_quartiere = a.id_quartiere
    group by i.id,
    tsi.id,
    tsi.descrizione,
    i.data_creazione, 
    i.elemento_id, 
    i.piazzola_id,
    i.utente,
    tp.descrizione,
    i.descrizione,
    te.volume, 
    tr.nome
    UNION
    select i.id,
    string_agg(ti.descrizione, ',') as tipo_intervento,
    tsi.id as id_stato_intervento,
    tsi.descrizione as stato_intervento,
    i.data_creazione, 
    i.elemento_id, 
    i.piazzola_id,
    i.utente,
    tp.descrizione as priorita,
    i.descrizione as desc_intervento,
    te.volume, 
    tr.nome as rifiuto
    from gestione_oggetti.intervento i 
    join (select a.intervento_id, b.tipo_stato_intervento_id as stato_corrente  
    from (select intervento_id, max(data_ora) as data_ora 
    from gestione_oggetti.intervento_tipo_stato_intervento 
    group by intervento_id) a
    join gestione_oggetti.intervento_tipo_stato_intervento b on a.intervento_id= b.intervento_id and a.data_ora= b.data_ora ) si on i.id = si.intervento_id 
    join gestione_oggetti.tipo_stato_intervento tsi on si.stato_corrente = tsi.id
    JOIN gestione_oggetti.intervento_tipo_intervento iti on iti.intervento_id = i.id 
    JOIN gestione_oggetti.tipo_intervento ti on ti.id = iti.tipo_intervento_id 
    join gestione_oggetti.tipo_priorita tp on i.tipo_priorita_id = tp.id 
    left JOIN elem_temporanei.elementi e2 on e2.id_elemento = i.elemento_id
    left JOIN elem.tipi_elemento te on te.tipo_elemento = e2.tipo_elemento
    left join elem.tipi_rifiuto tr on tr.tipo_rifiuto = te.tipo_rifiuto 
    JOIN elem.piazzole p on p.id_piazzola =i.piazzola_id 
    JOIN elem.aste a on a.id_asta = p.id_asta
    JOIN topo.vie v on a.id_via = v.id_via
    JOIN topo.comuni c on c.id_comune = v.id_comune
    JOIN topo.ut u on a.id_ut = u.id_ut
    JOIN topo.quartieri q on q.id_quartiere = a.id_quartiere
    group by i.id,
    tsi.id,
    tsi.descrizione,
    i.data_creazione, 
    i.elemento_id, 
    i.piazzola_id,
    i.utente,
    tp.descrizione,
    i.descrizione,
    te.volume, 
    tr.nome
    ) idf
    where id_stato_intervento not in (3,4)
    group by id, tipo_intervento,
    stato_intervento, data_creazione, 
    elemento_id, 
    piazzola_id,
    utente,
    priorita,
    desc_intervento
    order by 1;";


    //print $query;

    $result = pg_prepare($conn, "my_query", $query);
    $result = pg_execute($conn, "my_query", array());

    $rows = array();
    while($r = pg_fetch_assoc($result)) {
        $rows[] = $r;
        //print $r['id'];
    }
    
    
    //pg_close($conn);
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
}


?>