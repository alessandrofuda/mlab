

<div id="template_1" style="display: none;">
	<p>import template: template-1_AAAA</p>
</div>



<div id="template_2" style="display: none;">
	<p>import template: template-2_BBBB</p>
</div>



<div id="template_3" style="display: none;">
	<p>SDKHFSDKHSDFJ import template: template-3_CCCC</p>
</div>



<div id="template_4" style="display: none;">
	<p>import template: template-4_DDDDD</p>
</div>



<div id="template_5" style="display: none;">
	<p>import template: template-5_EEEEE</p>
</div>




{{-- ALL TEMPLATES LIST --}}
<script>
	// var template_1 = $('#template_1').html();		
	// var template_2 = $('#template_2').html();
	// var template_3 = $('#template_3').html();
	// var template_4 = $('#template_4').html();
	// var template_5 = $('#template_5').html();

	@foreach ($widgets as $widget)
		
		var template_{{ $widget->widget_id }} = $('#template_{{ $widget->widget_id }}').html();

	@endforeach
</script>