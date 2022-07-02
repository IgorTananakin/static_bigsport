<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// echo "123";
require_once( dirname(__DIR__) . '/wp-load.php');  //Подключаем wordpress
// var_dump(dirname(__DIR__));
wp_head();   //подгружаем стили которые в шапке

// пример шорткода 
 echo do_shortcode( '[elementor-template id="439785"]' );  //секция шапки сайта с лого и входом
if ( is_user_logged_in() ) {
?>
<script>
	

    window.onload = function() {
    
    jQuery(function() {
        jQuery('.selectpicker').selectpicker();
      });
            
    (function($) {
        function setChecked(target) {
            var checked = $(target).find("input[type='checkbox']:checked").length;
            if (checked) {
                $(target).find('select option:first').html('Выбрано команд: ' + checked);
            } else {
                $(target).find('select option:first').html('Выберите команду');
            }
        }
     
        $.fn.checkselect = function() {
            
            let popup4ik = document.createElement('div');
            popup4ik.className='checkselect-popup'
    
    
    
            this.wrapInner(popup4ik);
            
            this.prepend(
                '<div class="checkselect-control" >' +
                    '<select class="form-control " style="height:40px; margin-bottom:10px;" id="select-country" data-live-search="true"><optgroup label="Swedish Cars"><option data-tokens="футбол" ></option><optgroup></select>' +
                    '<div class="checkselect-over"></div>' +
                '</div>'
            );	
     
            this.each(function(){
                setChecked(this);
            });		
            this.find('input[type="checkbox"]').click(function(){
                
                setChecked($(this).parents('.checkselect'));
            });
     
            this.parent().find('.checkselect-control').on('click', function(){
                console.log('hi');
                $popup = $(this).next();
                $('.checkselect-popup').not($popup).css('display', 'none');
                if ($popup.is(':hidden')) {
                    $popup.css('display', 'block');
                    $(this).find('select').focus();
                } else {
                    $popup.css('display', 'none');
                }
                
                
            });
     
            $('html, body').on('click', function(e){
                
                if ($(e.target).closest('.checkselect').length == 0){
                    $('.checkselect-popup').css('display', 'none');
                }
            });
        };
        
        
        
    })(jQuery);	
        jQuery('.checkselect').checkselect();
    }
    
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    
    


<?php 
//для выбора только 6 месяцев
$date = date("Y-m-d");
$date = strtotime($date);
$date = strtotime("-6 month", $date);

?>
 <!doctype html>
<html lang="ru">
<head>
  <!-- Кодировка веб-страницы -->
  <meta charset="utf-8">
  <!-- Настройка viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Форма выгрузки</title> 


  <!-- стили для множественного выбора -->
  <link rel="stylesheet" href="css/style_for_many_select.css">
  <!-- Bootstrap CSS (jsDelivr CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
  <!-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

</head>
<body>
<style>
.form-control{margin-bottom:13px}
</style>


<?php //var_dump($mas); ?>
<div class="container  ">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
        <legend><a href="https://bootstraptema.ru/stuff/0-0-0-0-1"><i class="glyphicon glyphicon-home"></i></a> Форма выгрузки</legend>
            <form action="phpspreadsheet/get_static.php" method="post" class="form" role="form">
                <label for="date">Выгрузить</label>
                <input type="date" class="form-control" id="date_start" name="date_start" placeholder="Дата" min="<?php echo date('Y-m-d', $date);?>" max="<?php echo  date('Y-m-d');?>" required> 
                <label for="date_end">Выгрузить по</label>
                <input type="date" class="form-control" id="date_end" name="date_end" placeholder="Дата" min="<?php echo date('Y-m-d', $date);?>" max="<?php echo  date('Y-m-d');?>" required>
                
                <label for="date">Команды</label>
                <div class="row">
                    <div class="col-xs-6 col-md-6" id="team">

                    </div>
                    
                    <!-- если только по командам -->
                    <!-- <div class="col-xs-5 col-md-5"> -->
                        <div class="checkselect">
                        <!-- <optgroup label="Alaskan/Hawaiian Time Zone"> -->
                            <?php 
                            $teams_MNHL = $wpdb->get_results('SELECT wp_posts.ID,wp_posts.post_title FROM wp_posts
                            WHERE wp_posts.ID IN (255352, 255359, 255360, 255361, 25536, 255363)
                            GROUP BY wp_posts.post_title', ARRAY_A);?> 
                                  <label for=""><strong>MNHL Лига </strong></label> 
                            <?php
                                foreach($teams_MNHL as $key => $value) { 
                                    $name_team = $teams_MNHL[$key]['post_title']; ?>
                                    <label>Команда <input type="checkbox"  name="teams[]" value="<?php echo $name_team;?>" > <?php echo $name_team;?></label>
                            <?php } ?>

                            <?php 
                            $teams_MNHL_B = $wpdb->get_results('SELECT wp_posts.ID,wp_posts.post_title FROM wp_posts
                            WHERE wp_posts.ID IN (320465, 320466, 320467, 320468, 320469, 320470)
                            GROUP BY wp_posts.post_title', ARRAY_A);?> 
                                  <label for=""><strong>MNHL B Лига </strong></label> 
                            <?php
                                foreach($teams_MNHL_B as $key => $value) { 
                                    $name_team = $teams_MNHL_B[$key]['post_title']; ?>
                                    <label>Команда <input type="checkbox"  name="teams[]" value="<?php echo $name_team;?>" > <?php echo $name_team;?></label>
                            <?php } ?>

                            

                        </div>
                    <!-- </div> -->

                </div>
                <label for="date">Формат выгрузки</label>
                <select class="form-control " style="height:40px; margin-bottom:10px;" name="format" id="">
                    <option value="xlsx">XLSX</option>
                    <option value="google_table">Google table</option>
                </select>
                

                <button class="btn btn-lg btn-primary btn-block" type="submit" style="background:#0d6efd;">Запросить</button>
            </form>
        </div>
    </div>

 </div>


<?php ?>
</body>
<!-- script множественного выбора -->
<!-- <script src="js/script_for_many_select.js"></script> -->
<!-- script событий -->

<script src="js/events.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script> -->
</html>
	
<?php
// Пример запроса к базе вордпресса
// $teams = $wpdb->get_results('SELECT wp_posts  и т.д. ', ARRAY_A);

	
	

}

//get footer  подгружаем футер + стили для элементора
get_footer();

?>