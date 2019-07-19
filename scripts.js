// // Apply DataTables
//    $(document).ready( function () {
//     $('#table').DataTable();
// } );

// datatables to order multiple columns
$(document).ready(function() {
	$('#table').DataTable({
		dom: 'BRSfrtip',
		select: true,
		buttons: [
            {
				extend: 'copy',
				text: 'Copy',
				className: 'datatablebtn',
				key: {
					key: 'c',
					altKey: true
				}
			},
					
            {
				extend: 'collection',
                text: 'Export',
                className: 'datatablebtn',
				buttons: [ {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'datatablebtn',
                    filename: 'jay',
                    key: {
                        key: 'e',
                        altKey: true
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5,6 ]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'datatablebtn',
                    filename: 'jay',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5,6 ]
                    }  
                }   ]
            },    

		
			{
				extend: 'print',
				text: 'Print',
				className: 'datatablebtn',
				key: {
					key: 'p',
					altKey: true
				}
			}
		],
        
        // responsive: {
        //     details: {
        //         type: 'column',
        //         target: -1
        //     }
        // },
        // columnDefs: [ {
        //     className: 'control',
        //     orderable: false,
        //     targets:   -1
        // } ],
		responsive: {
            
            breakpoints: [
                { name: 'desktop', width: Infinity },
                { name: 'tablet',  width: 1024 },
                { name: 'fablet',  width: 768 },
                { name: 'phone',   width: 480 }
            ]
        },
		columnDefs: [
			//  { "width": "10%", "targets": [0,1,2,3,4] },
			{
				targets: [ 0 ],
				orderData: [ 0, 1 ]
			},
			{
				targets: [ 1 ],
				orderData: [ 1, 0 ]
			},
			{
				targets: [ 4 ],
				orderData: [ 4, 0 ]
			}
		],

        //save table sorting
		stateSave: true,


		language: {
			decimal: ',',
			thousands: '.'
		},

        autoWidth: true,
        responsive: true,
        // columnDefs: [
        //     { responsivePriority: 1, targets: 0 },
        //     { responsivePriority: 10001, targets: 3 },
        //     { responsivePriority: 2, targets: -2 }
        // ],

		scrollY:        '60vh',
		scrollCollapse: true,
		paging:         false
	});
});
