<?php
/**
Template Name :Record page stats Layout
File : tem.php
*/
get_header(); 
global $wpdb;
?>

<script language="javascript">
<?php
$pgid=$_GET['page_id'];
?>
var mycity;
var mycity2;
var reign;
var lati;
var timeonpage = 0;
setInterval(function() {
timeonpage = timeonpage + 100;
}, 100)
if (typeof geoip_city != "function" ) {
mycity = '';
mycity2 = 'Home';

} else {
mycity = ''+ geoip_city();
mycity2 = '' + geoip_city();
reign=geoip_country_code();

country = geoip_country_name();				
if (mycity != '') {
mycity = 'Near '+mycity;
mycity2 = ''+ mycity2;
} else {
mycity ='';
mycity2 = 'Home';
}
}  lati=geoip_latitude();
</script>

<?php


while(have_posts()) : the_post();			
$permalink = get_permalink( get_the_ID() );

$statusPage=get_post_meta(get_the_ID(), '_my_roi_status',true);
$pgid=get_the_ID();
	
get_template_part( 'content', 'page' ); 
comments_template( '', true );
get_footer();
endwhile;
?>






<?php
if(!$_GET['o']) {

if($statusPage==1) {
?>
<script language="javascript">	

$(window).bind('beforeunload', function(){
var wheigh=$(window).height();
var doch = $(document).height();
var mtop = $(document).scrollTop();
	$.ajax({
	type: "POST",
	    url: ajaxurl,
        data: "action=getmydata&timeonpage="+timeonpage+"&city="+mycity+"&wheight="+doch+"&dscroll="+mtop+"&pid=<?php echo $pgid;?>&wh="+wheigh,
	success: function(msg){
	     alert( "Data Saved: " + msg );
	}
});					
		return true;
	});

</script>			
<?php } } ?>					   
					 
					   