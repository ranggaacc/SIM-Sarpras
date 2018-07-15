$(document).ready(function() {
	$('.itemName').select2({
        placeholder: 'Select an item',
        ajax: {
          url: "{{ route('autocomplete2') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {

                    
                    return {
                        text:item.nama_barang,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }

      });
})