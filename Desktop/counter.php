<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>New Apple-Style Flip Counter Demo</title>
	

	<!-- My flip counter script, REQUIRED -->
	<script type="text/javascript" src="js/flipcounter.js"></script>
	<!-- Style sheet for the counter, REQUIRED -->
	<link rel="stylesheet" type="text/css" href="css/counter.css" />
	

	<!-- NOT REQUIRED FOR COUNTER TO FUNCTION, JUST FOR DEMO PURPOSES -->
	<!-- jQuery from Google CDN, NOT REQUIRED for the counter itself -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<!-- jQueryUI from Google CDN, used only for the fancy demo controls, NOT REQUIRED for the counter itself -->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<!-- Style sheet for the jQueryUI controls, NOT REQUIRED for the counter itself -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
	<!-- Style sheet for the demo page, NOT REQUIRED for the counter itself -->
	<link rel="stylesheet" type="text/css" href="css/demo.css" />

</head>

<body>
<div id="wrapper"><div id="flip-counter" class="flip-counter"></div></div>

	
			<div class="explain toggle">
				<p>These buttons start and stop auto-incrementing the counter using the <b>setAuto</b> method:</p>
				<code>myCounter.setAuto(false);</code>
				<p>When auto-increment is off, you can use the third button to step through the animation one increment at a time using the <b>step</b> method:</p>
				<code>myCounter.step();</code>
			</div>
		</li>
		<li class="auto_off_controls">Addition / Subtraction: <a href="#" class="expand">[?]</a>
			<div id="add_sub" class="demo_button">
				<button id="add">Add 567</button>
				<button id="sub">Subtract 567</button>
			</div>
			<div class="explain toggle">
				<p>You can also add and subtract a value to/from the counter using the <b>add</b> and <b>subtract</b> methods:</p>
				<code>myCounter.add(567);</code>
				<code>myCounter.subtract(567);</code>
			</div>
		</li>
		<li class="auto_off_controls">Set Value: <a href="#" class="expand">[?]</a>
			<div class="demo_button">
				<button id="set_val">Set value of counter to 12,345</button>
			</div>
			<div class="explain toggle">
				<p>You can manually set the value of the counter at any time using the <b>setValue</b> method:</p>
				<code>myCounter.setValue(12345);</code>
			</div>
		</li>
		<li class="auto_off_controls">Increment To: <a href="#" class="expand">[?]</a>
			<div class="demo_button">
				<button id="inc_to">Increment counter to 12,345</button>
			</div>
			<div class="explain toggle">
				<p>You can set the counter to increment to a value using the current <i>pace</i> and <i>inc</i> values by using the <b>incrementTo</b> method:</p>
				<code>myCounter.incrementTo(12345);</code>
			</div>
		</li>
		<li class="auto_off_controls">Smart Increment To: <a href="#" class="expand">[?]</a>
			<div class="demo_button">
				<button id="smart">Run smart increment example</button>
			</div>
			<div class="explain toggle">
				<p>You can also let the counter figure out the best <i>pace</i> and <i>inc</i> values using a "smart" increment technique.</p>
				<code>myCounter.incrementTo(12345, 10, 400);</code>
				<p>The above code would tell the counter to increment to 12,345 over a period of 10 seconds. I've also set a desired pace of 400 for the animation, but that will change when neccessary to optimize the animation.</p>
				<p>Click the "Run smart increment example" button to see a demo of this method in which the counter will increment to 4 different values, each with a duration of 10 seconds, dynamically adjusting <i>pace</i> and <i>inc</i> for optimal results.</p>
			</div>
		</li>
	</ul>
    
	<?php
	include ('connection.php');
	include ('retrieve.php');
	//$val_start="130000001";
	$val_end="3";
	?> 
<script type="text/javascript">
	//<![CDATA[
var v1=<?php echo $rownum;?>;
var v2=<?php echo $val_end;?>;
//alert(v1+v2)
	$(function(){
		// Initialize a new counter
		var myCounter = new flipCounter('flip-counter', {value:v1, inc:v2, pace:1000, auto:false});
 $(document).ready(function(){
   setInterval(function() {  
       location.reload(true); 
   }, 5000);  
 });
		/**
		 * Demo controls
		 */
		
		var smartInc = 0;
		
		// Increment
		$("#inc_slider").slider({
			range: "max",
			value: 123,
			min: 1,
			max: 1000,
			slide: function( event, ui ) {
				myCounter.setIncrement(ui.value);
				$("#inc_value").text(ui.value);
			}
		});
		
		// Pace
		$("#pace_slider").slider({
			range: "max",
			value: 600,
			min: 100,
			max: 2000,
			step: 100,
			slide: function( event, ui ) {
				myCounter.setPace(ui.value);
				$("#pace_value").text(ui.value);
			}
		});
		
		// Auto-increment
		$("#auto_toggle").buttonset();
		$("input[name=auto]").change(function(){
			if ($("#auto1:checked").length == 1){
				$("#counter_step").button({disabled: true});
				$(".auto_off_controls").hide();
				$(".auto_on_controls").show();
				
				myCounter.setPace($("#pace_slider").slider("value"));
				myCounter.setIncrement($("#inc_slider").slider("value"));
				myCounter.setAuto(true);
			}
			else{
				$("#counter_step").button({disabled: false});
				$(".auto_off_controls").show();
				$(".auto_on_controls").hide();
				$("#add_sub").buttonset();
				$("#set_val, #inc_to, #smart").button();
				myCounter.setAuto(false).stop();
			}
		});
		$("#counter_step").button({disabled: true});
		$("#counter_step").button().click(function(){
			myCounter.step();
			return false;
		});
		
		// Addition/Subtraction
		$("#add").click(function(){
			myCounter.add(567);
			return false;
		});
		$("#sub").click(function(){
			myCounter.subtract(567);
			return false;
		});
		
		// Set value
		$("#set_val").click(function(){
			myCounter.setValue(12345);
			return false;
		});
		
		// Increment to
		$("#inc_to").click(function(){
			myCounter.incrementTo(12345);
			return false;
		});
		
		// Get value
		$("#smart").click(function(){
			var steps = [12345, 17, 4, 533];

			if (smartInc < 4) runTest();
			
			function runTest(){
				var newVal = myCounter.getValue() + steps[smartInc];
				myCounter.incrementTo(newVal, 10, 600);
				smartInc++;
				if (smartInc < 4) setTimeout(runTest, 10000);
			}
			$(this).button("disable");
			return false;
		});
		
		// Expand help
		$("a.expand").click(function(){
			$(this).parent().children(".toggle").slideToggle(200);
			return false;
		});

	});
	</script>
	

<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-2157689-3']);
	_gaq.push(['_trackPageview']);
	_gaq.push(['_trackPageLoadTime']);

	(function(){
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www')+'.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
</script>
<script type="text/javascript">
	var clicky_site_ids = clicky_site_ids || [];
	clicky_site_ids.push(125897);
	(function(){
		var s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.src = '//static.getclicky.com/js';
		( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild(s);
	})();
</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/125897ns.gif"/></p></noscript>
</body>

</html>