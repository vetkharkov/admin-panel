<script>
    var route = "{{ route('adminzone.admin.search.search') }}";

    $('#search').typeahead({
        source: function (term, process) {
            return $.get(route, {term: term}, function (data) {
                return process(data);
            });
        }
    });
</script>