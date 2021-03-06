<?php
use Illuminate\Support\Facades\Input;
//dd(Input::all());

// Keywords
$keywords = Input::get('q');

// Category
$qCategory = (isset($cat) and !is_null($cat)) ? $cat->tid : Input::get('c');

// Location
if (isset($city) and !is_null($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
} else {
	$qLocationId = Input::get('l');
	$qLocation = Input::get('location');
}
?>
<div class="container">
	<div class="search-row-wrapper">
		<div class="container">
			<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')])) }}" method="GET">
				<div class="col-sm-4" style="padding-left: 1px; padding-right: 1px;">
					<input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}" value="{{ $keywords }}">
				</div>
				<div class="col-sm-3" style="padding-left: 1px; padding-right: 1px;">
					<select name="c" id="search_category" class="form-control selecter">
						<option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
						@if (!$cats->isEmpty())
							@foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
								<option{{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }}
										value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="col-sm-3 search-col locationicon" style="padding-left: 1px; padding-right: 1px;">
					<i class="icon-location-2 icon-append" style="margin-top: -6px; margin-left: 1px;"></i>
					<input type="text" id="loc_search" name="location" class="form-control locinput input-rel searchtag-input has-icon"
						   placeholder="{{ t('Where?') }}" value="{{ $qLocation }}">
				</div>
				@if (Request::has('r'))
				<input type="hidden" id="l_search" name="r" value="{{ $qLocation }}">
				@else
				<input type="hidden" id="l_search" name="l" value="{{ $qLocationId }}">
				@endif
				<div class="col-sm-2" style="padding-left: 1px; padding-right: 1px;">
					<button class="btn btn-block btn-primary"><i class="fa fa-search"></i></button>
				</div>
				{!! csrf_field() !!}
			</form>
		</div>
	</div>
	<!-- /.search-row  width: 24.6%;-->
</div>