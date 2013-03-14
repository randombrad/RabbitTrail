<?php
	include_once("connect.php");
	
	$sql=" SELECT * FROM `RunningLog`";
	$result=mysql_query($sql);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
		

	$user_id="Brad Wood";
	echo "

<chart>

	<axis_category size='12' color='000000' alpha='75' font='arial' bold='true' skip='0' orientation='horizontal' />
	<axis_ticks value_ticks='false' category_ticks='true' major_thickness='1' minor_thickness='0' minor_count='1' major_color='000000' minor_color='222222' position='inside' />
	<axis_value min='0' max='12' font='arial' bold='true' size='10' color='ffffff' alpha='50' prefix='' suffix='' decimals='0' separator='' show_min='false' />

	<chart_border color='000000' top_thickness='1' bottom_thickness='2' left_thickness='1' right_thickness='1' />
	<chart_data>
		<row>
			<null/>";
			$num_rows = mysql_num_rows($result);
			$i=0;
			while($i<$num_rows){
				echo "<string>x</string><string>y</string>\n";
				$i++;
			}
		echo "
		</row>
		<row>
			<string>player 1</string>";
			while($row=mysql_fetch_array($result)){
			echo "<number>$row[5]</number>";
			}
			echo "
		</row>
		<row>
			<string>player 2</string>";
			while($row=mysql_fetch_array($result)){
			$rh=date("H",mktime($row[4]));
			$hmin=$rh*60;
			$rm=date("m",mktime($row[4]));
			$totalmin=$rm+$hmin;
			$totalsec=$totalmin/60;
			echo "<number>$totalsec</number>";
			}
			echo "
		</row>
	</chart_data>
	<chart_grid_h alpha='10' color='000000' thickness='1' />
	<chart_grid_v alpha='20' color='000000' thickness='2' type='dotted' />
	<chart_pref point_size='5' trend_alpha='20' trend_thickness='2' />
	<chart_rect x='20' y='20' width='340' height='190' positive_color='000000' positive_alpha='25' negative_color='ff0000' negative_alpha='10' />
	<chart_type>scatter</chart_type>
	<chart_value position='cursor' bold='true' size='12' color='ffffff' alpha='75' />

	<draw>
		<text color='ffffff' alpha='20' font='arial' bold='true' size='25' x='45' y='183' width='400' height='150' h_align='left' v_align='top'>Distance</text>
		<text color='ffffff' alpha='20' rotation='-90' bold='true' size='25' x='-15' y='210' width='200' height='60' h_align='left' v_align='bottom'>Score</text>
		<text color='ffffff' alpha='3' rotation='-10' bold='true' size='100' x='260' y='180'>?</text>
		<text color='ffffff' alpha='3' rotation='10' bold='true' size='100' x='15' y='100'>?</text>
		<text color='ffffff' alpha='3' rotation='45' bold='true' size='100' x='225' y='-20'>?</text>
		<text color='ffffff' alpha='3' rotation='-45' bold='true' size='100' x='10' y='-10'>?</text>
		<text color='ffffff' alpha='3' rotation='0' bold='true' size='100' x='350' y='30'>?</text>
	</draw>
	 <legend_label layout='horizontal' 
                 bullet='circle'
                 font='arial'
                 bold='true'
                 size='12'
                 color='ffffff'
                 alpha='50'
                 /> 

	<legend_rect x='360' y='20' width='10' width='200' margin='3' fill_color='ffffff' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' />

	<series_color>
		<color>88ff00</color>
		<color>ff8800</color>
	</series_color>
	
</chart>

";

?>