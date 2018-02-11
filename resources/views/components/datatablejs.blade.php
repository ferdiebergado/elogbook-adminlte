<script src="{{ mix('js/plugins.js') }}"></script>
<script>
    $(function() {
     var dTable = $('#{{ $datatableid }}').DataTable({
        serverSide:         true,
        searchHighlight:    true,
        ajax: {
            url:    '{{ $datatableroute  }}',
            data:   function ( d ) {
                        var datatable = $('#{{ $datatableid }}').DataTable();
                        var info = datatable.page.info();
                        var dir = '';
                        var sortField = '';
                        var i = 0;
                        var firstSort = true;
                        var sortMultiple = '';
                        var firstMultiple = true;
                        var sortMultipleDir = '';
                        while (d.order[i]) {
                            if (firstSort) {
                                sortField = d.columns[d.order[i].column].name;
                                firstSort = false;
                                dir = d.order[i].dir;
                            } else {
                                if (firstMultiple) {
                                    sortMultiple = d.columns[d.order[i].column].name;
                                    sortMultipleDir = d.order[i].dir;
                                    firstMultiple = false;
                                } else {
                                    sortMultiple = sortMultiple + ';' + d.columns[d.order[i].column].name;
                                    sortMultipleDir = sortMultipleDir + ';' + d.order[i].dir;
                                }
                                d.orderByMulti = sortMultiple;
                                d.sortedByMulti = sortMultipleDir;
                            }
                            i++;
                        }
                        d.with = '{{ $datatablewith }}';
                        d.searchText = d.search.value;
                        d.orderBy = sortField;
                        d.sortedBy = dir;
                        d.page = info.page + 1;                                    
                        d.route = function () {
                            var url = window.location;
                            var a = $('<a>', { href:url })[0];
                            return a.search.split('=')[1];
                        };                                    
                    },
            dataFilter: function(data){
                            var json = jQuery.parseJSON( data );
                            json.recordsTotal = json.data.total;
                            json.recordsFiltered = json.data.total;
                            json.data = json.data.data;
                            return JSON.stringify( json ); // return JSON string
                        }                
            }, //ajax
            columnDefs: [
                            {
                                type:       "html",
                                orderable:  false,
                                searchable: false,
                                // The `data` parameter refers to the data for the cell (defined by the
                                // `data` option, which defaults to the column being worked with, in
                                // this case `data: 0`.
                                render:     function ( data, type, row ) {
                                                const viewroute =   '{{ $datatableurl }}';
                                                const editroute =   viewroute + '/' + data + '/edit';
                                                const buttons =     
                                                        {
                                                            view: {
                                                                    color: 'purple',  
                                                                    icon: 'info-sign',
                                                                    title: 'View'
                                                                    },
                                                            edit:       {
                                                                color: 'maroon',  
                                                                icon: 'edit',
                                                                title: 'Update'
                                                            },                                             
                                                        };
                                                    var viewlink = viewroute + '/' + data;
                                                    var editlink = editroute;
                                                    var editbtn = generateBtn(buttons.edit.color, editlink, buttons.edit.icon, buttons.edit.title);
                                                    var viewbtn = generateBtn(buttons.view.color, viewlink, buttons.view.icon, buttons.view.title);
                                                    function generateBtn(color, link, icon, title) {
                                                        let head = `<a class="btn btn-flat btn-sm bg-${color}" href="`;
                                                        let end = `" title="${title}" style="margin-top: 3px; margin-left: 3px" role="button"><i class="glyphicon glyphicon-${icon}"></i></a>`;   
                                                        return head + link + end;
                                                    }
                                                    return viewbtn {{ auth()->user()->role !== 4 ? '+ editbtn':'' }};
                                            },
                                targets:    {{ $datatabletargetcol }}
                            },
                            {
                              targets:  {{ $ellipsiscol }},
                              render:   Ellipsis(30, true)
                                // $.fn.dataTable.render.ellipsis( 60, true )
                            }, 
                            {
                                targets:    1,
                                render:     function (data, type, row) {
                                                var task = '';
                                                var tskcolor = '';
                                                if (data == 'I') {
                                                    task = 'Received';
                                                    tskcolor = 'primary';
                                                } else if (data == 'O') {
                                                    task = 'Released';
                                                    tskcolor = 'success';
                                                } else {
                                                    return data;
                                                }
                                                return `<span class=\"label label-${tskcolor}\">${task}</span>`;
                                            }
                            },
                            {
                                targets:    0,
                                render:     function (data, type, row) {
                                                return `<span class=\"label bg-teal\">${data}</span>`;
                                            }
                            }                            
                // { visible: false,  "targets": [ 3 ] }
                        ],
        columns:    [       
                        {{ $slot }}   
                    ],
        // order:  [[ 7, 'desc']],
        order:      [],
        dom:        'B<f>rtilp',
        responsive: true,
        stateSave:  true,
        buttons:    [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
        initComplete:   function() {
                            var $searchInput = $('div.dataTables_filter input');
                            $searchInput.unbind();
                            $searchInput.bind('keyup', function(e) {
                                if(e.keyCode == 13) {
                                    dTable.search( this.value ).draw();
                                }
                            });
                        }                
        });
});
</script>
