<?php
/**
 * Plugin Name: Pulse preloader
 * Plugin URI: http://get.phpvibe.com/
 * Description: CSS3 only pulse preloader
 * Version: 1
 * Author: PHPVibe Crew
 * Author URI: http://www.phpvibe.com
 * License: Commercial
 */
function pulsehtml($txt= ''){
echo '
<div class="pulser-holder">
            <div class="thepulser">
                <div></div>
                <div></div>
            </div>
        </div>
';	
}
function pulsecss($txt = '') {
$css= '
<style>
.pulser-holder {
  position: fixed;
  z-index: 999;
  background-color: #ffffff;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.thepulser {
  top: 50%;
  left: 50%;
  position: absolute;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
}

@keyframes pulser {
  0% {
    top: 96px;
    left: 96px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 18px;
    left: 18px;
    width: 156px;
    height: 156px;
    opacity: 0;
  }
}
@-webkit-keyframes pulser {
  0% {
    top: 96px;
    left: 96px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 18px;
    left: 18px;
    width: 156px;
    height: 156px;
    opacity: 0;
  }
}
.thepulser div {
  box-sizing: content-box;
  position: absolute;
  border-width: 4px;
  border-style: solid;
  opacity: 1;
  border-radius: 50%;
  -webkit-animation: pulser 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
  animation: pulser 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}

.thepulser div:nth-child(1) {
  border-color: #eb1436;
}

.thepulser div:nth-child(2) {
  border-color: #eb1436;
  -webkit-animation-delay: -0.5s;
  animation-delay: -0.5s;
}

.thepulser {
  width: 100px !important;
  height: 100px !important;
  margin-left:-48px;
  position: relative;
  -webkit-transform: translate(-50px, -50px) scale(0.5) translate(50px, 50px);
  transform: translate(-50px, -50px) scale(0.5) translate(50px, 50px);
}
</style>
';

return $txt.pluser_remove_spaces($css);
}

function pulsejs($txt = ''){
$js = '
<script>
$(document).ready(function() {
$(".pulser-holder").remove();	
});
</script>
';	
return $txt.pluser_remove_spaces($js);
}
if (!function_exists('pluser_remove_spaces')) { 
// Minify output
function pluser_remove_spaces($string){
    $string = preg_replace("/\s{2,}/", " ", $string);
    $string = str_replace("\n", "", $string);
    $string = str_replace(', ', ",", $string);
    return $string;
}
}
add_filter('filter_extracss', 'pulsecss');
add_filter('filter_extrajs', 'pulsejs');
add_action('vibe_footer', 'pulsehtml', 0);
?>