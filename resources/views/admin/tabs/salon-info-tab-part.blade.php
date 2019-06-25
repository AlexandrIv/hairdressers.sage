<div class="salon-info">
  <form id="salon-form">
    <input type="hidden" name="action" value="salon_form">
    <input type="hidden" name="post_id" value="{!! $get_salon_info['ID'] !!}">
    <label class="box" for="salon-name"><span>Le nom du Salon:</span>
      <input type="text" name="salon_name" id="salon-name" value="{!! $get_salon_info['name'] !!}">
    </label>
    <label class="box radio"><span>Sélectionnez le type de service:</span>
      @foreach ($get_salon_info['category'] as $key => $category)
      <label for="{!! $category->slug !!}">
        <input type="checkbox" name="salon_category[]" value="{!! $category->term_id !!}" id="{!! $category->slug !!}" @if ($get_salon_info['category_checked'])
        @foreach ($get_salon_info['category_checked'] as $term) @if($term->slug == $category->slug){!! 'checked' !!}@endif @endforeach @endif>
        <span>{!! $category->name !!}</span>
      </label>
      @endforeach
    </label>
    <label class="box" for="address"><span>Votre adresse:</span>
      <input type="text" name="address" id="address" value="{!! $get_salon_info['address'] !!}">
    </label>
    <label class="box" for="description"><span>Décrivez votre salon (visible aux clients):</span>
      <textarea name="description" id="description" rows="10">{!! $get_salon_info['description'] !!}</textarea>
    </label>
    <label><span>Select working days:</span></label>
    <div class="row working-days">
      <div class="col-12">
        @foreach ($working_day as $element)
        {!! $element !!}
        @endforeach
      </div>
    </div>
    <label class="box" for="images"><span>Upload images of your salon:</span>
      <input type="file" name="upload_attachment[]" class="images" id="images" size="50" multiple="multiple" />
    </label>
    <div class="row upload-images"></div>
    <label class="salon-save-form">
      <input type="submit" name="salon-save-form" class="button-salon-save-form" id="salon-save-form" value="Save" form="salon-form">
    </label>
  </form>
  <div id="status"></div>
</div>