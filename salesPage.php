<?php
/*
  Plugin Name:Sales Page Stats 
  Plugin URI: http://maskcode.com/salespagestats
  Description: Get proper report about your sales page that how many Visitors scroll your page, how many visitors scrolled full page and how much time they spent on page
  Version: 1.0.0
  Author: Mask Code 
  Author URI: http://maskcode.com/
 */
 class my_salespage_form {
  public $sdf;
    public function __construct() {
        global $wpdb;
		
		$pageName = "my-salespage-form-page";   
		add_action( 'admin_init', array(&$this,'my_admin_meta'));
		add_action( 'save_post', array(&$this, 'page_salespage_save' ) );		        
		add_filter('template_include',array(&$this,'so_13997743_custom_template'));		  
		
		add_action('wp_head', array(&$this, 'myajax_url'));
		
		add_action('wp_ajax_getmydata', array(&$this, 'get_ajax_data'));
        add_action('wp_ajax_nopriv_getmydata', array(&$this, 'get_ajax_data'));
		
		register_activation_hook(__FILE__, array(&$this, 'sales_activate'));
		register_deactivation_hook(__FILE__, array(&$this, 'sales_deactivate'));
	
	 
    }
	
	  function myajax_url(){
			global $wpdb;
			echo "\n" . '<script type="text/javascript">
			var ajaxurl="'.admin_url('admin-ajax.php').'";
			</script>' . "\n";			
			echo "\n".'<script src="http://code.jquery.com/jquery-1.9.1.js"></script>'."\n";
			echo "\n".'<script language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>'."\n";
     }
	
		public function get_ajax_data(){
        global $wpdb;
        $postID=trim($_POST['pid']);
        $wHeight=trim($_POST['wheight']);
        $dScroll=trim($_POST['dscroll']);
        $city=trim($_POST['mycity']);
        $timeonPage=trim($_POST['timeonpage']);
        $helpHeight=trim($_POST['wh']);


     $wpdb->query( $wpdb->prepare( 
				"
				INSERT INTO wp_page_stats
				( post_id, doc_height, scroll_top,time_on_page,page_city,wheight )
				VALUES ( %d, %s, %s ,%s ,%s ,%s)
				", 
				$postID, 
				$wHeight, 
				$dScroll,
				$timeonPage,
				$city,
				$helpHeight
				) );
				echo 'data saved';  
				die();
				
    }
	


	
	
	
	function sales_activate() {	
	    global $wpdb;
        $wpdb->query(file_get_contents(plugin_dir_path(__FILE__) .'/db.sql'));
	    
	}


	
	
	
	
	function sales_deactivate() {
	  global $wpdb;
        $SQL = "DROP TABLE " . $wpdb->prefix . "page_stats";
        $wpdb->query($SQL);
	}
	
		function my_admin_meta() { 
		add_meta_box('wpecbd_logo', _x('Page Stats', 'metabox_company_logo', 'wpecbd'), array(&$this, 'metabox_logo'), 'page', 'normal', 'high', NULL);
		add_meta_box('wpecbd_logo', _x('Page Stats', 'metabox_company_logo', 'wpecbd'), array(&$this, 'metabox_logo'), 'post', 'normal', 'high', NULL);
		}

function metabox_logo($post){
global $wpdb;
$pagesStatus=get_post_meta( $post->ID, '_my_roi_status',true);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID'";
$reportData=$wpdb->get_results($myquery);

// calculate percentage and store to db for next step.
foreach($reportData as $value) {
$doc_height=$value->doc_height;
$total_scroll=$value->scroll_top;
$row_id=$value->row_id;
$win_height=$value->wheight;



$total_scroll=$total_scroll+$win_height;


$cal=$total_scroll*100;
$cal=$cal/$doc_height;

$myquery="update " . $wpdb->prefix . "page_stats set total_perc='$cal' where post_id='$post->ID' and row_id='$row_id'";
$wpdb->query($myquery);
}



//another percarntege calculation area code
$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=10";
$reportData=$wpdb->get_results($myquery);
$tenPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=20";
$reportData=$wpdb->get_results($myquery);
$twePerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=30";
$reportData=$wpdb->get_results($myquery);
$thirPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=40";
$reportData=$wpdb->get_results($myquery);
$fortiPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=50";
$reportData=$wpdb->get_results($myquery);
$fiftPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=60";
$reportData=$wpdb->get_results($myquery);
$sixPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=70";
$reportData=$wpdb->get_results($myquery);
$sevenPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=80";
$reportData=$wpdb->get_results($myquery);
$eightPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=90";
$reportData=$wpdb->get_results($myquery);
$ninPerc=count($reportData);

$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID' and  total_perc>=100";
$reportData=$wpdb->get_results($myquery);
$hundPerc=count($reportData);


if(isset($_REQUEST['rest'])){

$myquery="delete from ". $wpdb->prefix . "page_stats where post_id='$post->ID'";;
$wpdb->get_results($myquery);

}


$myquery="select * from " . $wpdb->prefix . "page_stats where post_id='$post->ID'";
$reportData=$wpdb->get_results($myquery);

$totalScrolled=0;
$totalGotEop=0;
$totalmiliSecond=0;
foreach($reportData as $value) {

$totalmiliSecond=$totalmiliSecond+$value->time_on_page;

 if($value->scroll_top>0) {
 $totalScrolled=$totalScrolled+1;
 }
 
 $hl=$value->doc_height-$value->scroll_top;
 if($hl==$value->wheight) {
 $totalGotEop=$totalGotEop+1;
 }
 
 
 
 
}

if($totalScrolled>0) {

$totalPercScrolled=$totalScrolled*100;
$totalPercScrolled=$totalPercScrolled/count($reportData);

}
else  {$totalPercScrolled=0;}

if($totalGotEop>0) {
$totalPerEop=$totalGotEop*100;
$totalPerEop=$totalPerEop/count($reportData);
}else {$totalPerEop=0;}

?>
<table>
<tr>
<td style="font-size:12px;">Status</td>
<td><select name="roi_action" style="font-size:12px;width:310px;height:25px;">
<option value="0" <?php if($pagesStatus==0) echo "selected=selected";?>></option>
<option value="1" <?php if($pagesStatus==1) echo "selected=selected";?>>On</option>
<option value="2" <?php if($pagesStatus==2) echo "selected=selected";?>>Off</option>
</select>
</td>
</tr>
</table>

<?php
//echo count($reportData);
//echo "Total Scrolled :".$totalScrolled;
//echo "<br/>Total EOP:".$totalGotEop;
//echo "<br/> Average Time :".$totalmiliSecond/1000;
if($pagesStatus==1) {
?>
<table width="45%">

<tr>
<td><b>Total Scrolled down Users :</b> </td>
<td> <?php echo round($totalPercScrolled,2);?> %</td>
</tr>

<tr>
<td><b>Total Who got End of the Page :</b> </td>
<td> <?php echo round($totalPerEop,2);?> %</td>
</tr>

<tr>
<td><b>Avg. Time Spent On Page : </b></td>
<td> <?php echo $totalmiliSecond/1000;?> Seconds</td>
</tr>

<tr><td colspan="2"></td></tr>

<tr>
<td><a href='post.php?post=<?php echo $post->ID?>&action=edit&rest=0'>Reset Stats</a></td>
</tr>
</table>


<?php
}

}





function page_salespage_save($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	 return $post_id;
     

	$pageStatus=sanitize_text_field( $_POST['roi_action']);	
	update_post_meta( $post_id, '_my_roi_status', $pageStatus);
}


 function so_13997743_custom_template($template) {
        $template = plugin_dir_path(__FILE__) . 'tem.php';
         return $template;
}

}
new my_salespage_form();