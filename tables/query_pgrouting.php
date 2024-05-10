<?php
$query_pgrouting="select row_number() over(order by seq) as ordine, 
c.seq, b.id, b.id_piazzola, b.indirizzo_amiu,
b.num, b.riempimento_medio,
to_char(b.aggiornamenti, 'HH24:MI (DD/MM)') as aggiornamenti, 
st_y(b.geom) as lat, 
st_x(b.geom) as lon, 
b.geom  
from
input.punti b,
lateral (
select * from 
(select pr.seq, pr.node, pr.cost, pr.agg_cost, v.the_geom from
(
SELECT
     seq, node, cost, agg_cost
FROM
     pgr_TSP(
       $$
       SELECT * 
       FROM
         pgr_dijkstraCostMatrix(
           'SELECT gid as id, source, target, cost, reverse_cost FROM network.ways',
           (
            with nearestVertices as(
              SELECT a.id, p.id as id_punti 
              from
                input.punti p,
                lateral (
                  select id, the_geom 
                  from
                    network.ways_vertices_pgr wvp 
                  order by
                    wvp.the_geom <-> p.geom 
                  limit 1
               ) a
            )
            select array_agg(id) 
            from
               nearestVertices
          ), 
          directed := false
        )$$, 
        start_id := (select wvp3.id from input.punti p3,
network.ways_vertices_pgr wvp3
where p3.id=9999
  order by
    wvp3.the_geom <-> p3.geom 
  limit 1), 
        end_id := (select wvp3.id from input.punti p3,
network.ways_vertices_pgr wvp3
where p3.id=9999
  order by
    wvp3.the_geom <-> p3.geom 
  limit 1),
        randomize := false
) 
) pr
join network.ways_vertices_pgr  v on v.id = pr.node) al
order by 
al.the_geom <-> b.geom 
limit 1) c
order by seq";

?>