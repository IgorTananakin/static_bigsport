<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
class BD extends PDO {
    public function id_liga($idmath) {
        return $this->query('SELECT wp_terms.term_id FROM wp_postmeta 
                             INNER JOIN wp_term_relationships ON wp_postmeta.meta_value = wp_term_relationships.object_id 
                             INNER JOIN wp_terms ON wp_term_relationships.term_taxonomy_id = wp_terms.term_id 
                             WHERE wp_postmeta.post_id = "' . $idmath . '"' )->fetchAll(PDO::FETCH_ASSOC);
    }
    public function all_ligs() {
       return $this->query('SELECT wp_terms.term_id, wp_terms.name FROM wp_terms WHERE wp_terms.term_id IN(13735, 13494,13616, 13521, 20640, 16399, 13727, 20624, 13895, 13499, 13517, 13496, 19269, 16253)')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function all_ligs2() {
        return $this->query('SELECT wp_terms.term_id, wp_terms.name FROM wp_terms WHERE wp_terms.term_id IN(265947, 13494, 13521, 20640, 16399, 13727, 20624, 13895, 13499, 13517, 13496, 19269, 16253)')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function all_ligs3() {
        return $this->query('SELECT wp_terms.name, wp_posts.post_title FROM wp_terms 
                            INNER JOIN wp_term_relationships ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id 
                            INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id 
                            GROUP BY wp_posts.post_title 
                            ORDER BY `wp_posts`.`post_title` ASC LIMIT 30')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function term_id($name_lige) {
        return $this->query('SELECT * FROM wp_terms WHERE wp_terms.name = "' . $name_lige . '"');
    }



    public function t_id($t_id) {
        return $this->query('SELECT * FROM wp_terms 
                             INNER JOIN wp_joomsport_live_match_events ON wp_terms.term_id = wp_joomsport_live_match_events.t_id 
                             WHERE wp_terms.term_id = "' . $t_id . '"');
    }

    public function name_team() {
        return $this->query('SELECT wp_posts.post_title FROM wp_posts 
                            INNER JOIN wp_joomsport_live_match_events 
                            ON wp_posts.ID = wp_joomsport_live_match_events.t_id 
                             LIMIT 40')->fetchAll(PDO::FETCH_ASSOC);
    }
//рабочий 
    public function name_team2() {
        return $this->query('SELECT wp_posts.post_title FROM wp_posts
                            WHERE wp_posts.ID IN (204911,204878,202953,204662,202887,212951,204903,244059,207566,202959,207509,202908,204665,204900,202957,
202137,202898,207504,202903,204901,207491,202962,202153,204681,212954,204670,204896,205484,202952,204908,204669,204892,207508,229960,202909,202151,202157,202955,202942,272575,204909,204657,204897,204902,202138,204672,204674,204893,236091,202156,269718,202907,202943,202944,202963,202951,202904,204679,202888,204660,202897,204675,202893,202886,202954,202155,202900,202945,205479,212959,207505,202892,202899,202896,212958,204676,205481,204663,204874,204877,269716,212952,202905,202154,202152,202956,212953,202906,202960,204876,204664,230154,207510,202139,202885,202894,207506,207507,204894,202142,202950,202947,204673,229468,236098,212950,204895,205482,236100,204680,202158,207565,202949,205472,212956,212957,244057,272578,204682,202941,205480,204899,202144,202148,202143,202147,202149,202146,202150,202145,236096,204671,230157,202891,202890,244061,202902,204656,202964,202895,202946,207567,202889,202140,202961,204898,204875,202958,273392,204658,273394,273403,273398)
                            GROUP BY wp_posts.post_title
                            ')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function name_team_in_liga($liga) {
        return $this->query('SELECT wp_posts.post_title FROM wp_terms 
                            INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id 
                            INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.teamHomeID 
                            WHERE wp_terms.term_id = ' . $liga . ' 
                            GROUP BY wp_posts.post_title')->fetchAll(PDO::FETCH_ASSOC);
    }
//статистика
    public function sesson_static($start,$end,$teams_sql) {

        // $sql = "SELECT wp_terms.name as лига_с_дивизионом, wp_postmeta.meta_value as домашний_счёт, wp_posts.post_title as команды, wp_postmeta_1.meta_value as противника_счёт, wp_joomsport_matches.date as дата, wp_joomsport_matches.time as время FROM wp_terms 
        // INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id 
        // INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.postID
        // INNER JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
        // INNER JOIN wp_posts wp_posts_1 ON wp_posts_1.ID = wp_joomsport_matches.teamHomeID
        // INNER JOIN wp_postmeta wp_postmeta_1 ON wp_postmeta_1.post_id = wp_postmeta.post_id 
        // WHERE wp_postmeta.meta_key = '_joomsport_home_score' 
        // AND wp_postmeta_1.meta_key = '_joomsport_away_score' 
        // AND wp_joomsport_matches.date > '" . $start . "' 
        // AND wp_joomsport_matches.date < '" . $end . "'
        // AND wp_posts_1.post_title IN ('" . $teams_sql . "')
        // LIMIT 2";
        // var_dump($sql);


        
        return $this->query("SELECT wp_terms.name as лига_с_дивизионом,  wp_posts_1.post_title as хозяева,
                            wp_postmeta.meta_value as счёт_хозяев,wp_postmeta_1.meta_value as счёт_гостей, wp_posts_2.post_title as гости,
                            wp_joomsport_matches.date as дата,
                            wp_joomsport_matches.time as время FROM wp_terms 
                            INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id 
                            INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.postID 
                            INNER JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID 
                            INNER JOIN wp_posts wp_posts_1 ON wp_posts_1.ID = wp_joomsport_matches.teamHomeID 
                            INNER JOIN wp_posts wp_posts_2 ON wp_posts_2.ID = wp_joomsport_matches.teamAwayID 
                            INNER JOIN wp_postmeta wp_postmeta_1 ON wp_postmeta_1.post_id = wp_postmeta.post_id
                            WHERE wp_postmeta.meta_key = '_joomsport_home_score' 
                            AND wp_postmeta_1.meta_key = '_joomsport_away_score'
                            AND wp_joomsport_matches.date > '" . $start . "' 
                            AND wp_joomsport_matches.date < '" . $end . "'
                            AND wp_posts_1.post_title IN ('" . $teams_sql . "')
                            GROUP BY wp_posts.post_title")->fetchAll(PDO::FETCH_ASSOC);
    }

    
    //SELECT * FROM wp_terms INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.teamHomeID GROUP BY wp_posts.post_title;

    //SELECT wp_terms.term_id, wp_terms.name as сезон_с_лигой, wp_joomsport_matches.mdID, wp_posts.ID, wp_posts.post_title FROM wp_terms INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.teamHomeID GROUP BY wp_posts.post_title;

    // SELECT wp_terms.term_id, wp_terms.name as сезон_с_лигой, wp_joomsport_matches.mdID, wp_posts.ID, wp_posts.post_title, wp_joomsport_matches.date as дата_прохождения_матча, wp_joomsport_matches.time as время_прохождения_матча FROM wp_terms INNER JOIN wp_joomsport_matches ON wp_joomsport_matches.mdID = wp_terms.term_id INNER JOIN wp_posts ON wp_posts.ID = wp_joomsport_matches.teamHomeID;




//     SELECT * FROM wp_terms 
// INNER JOIN wp_term_relationships ON wp_terms.term_id = wp_term_relationships.term_taxonomy_id
// INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id ORDER BY `name`  DESC
}

$connection = new BD('mysql:host=localhost;dbname=scout;charset=utf8', 'scout', 'vI7mE2hS5rpR9u');
