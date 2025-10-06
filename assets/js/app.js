let jobs = $('.job');

let loc_filter = $('#loc-filter');
loc_filter.on( 'change', function(e) {
    let loc = this.value;

    if( loc == 'all' ) {
        jobs.removeClass('d-none');
    } else {
        $(jobs).each( function(i, item) {
            if( item.dataset.loc != loc ) {
                $(item).addClass('d-none');
            } else {
                $(item).removeClass('d-none');
            }
        } );
    }
} );

// let cat_filter = $('#cat-filter');
// cat_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.cat != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// let exper_filter = $('#exper-filter');
// exper_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.loc != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// let type_filter = $('#type-filter');
// type_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.loc != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// let quali_filter = $('#quali-filter');
// quali_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.loc != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// let gender_filter = $('#gender-filter');
// gender_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.loc != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// let salary_filter = $('#salary-filter');
// salary_filter.on( 'change', function(e) {
//     let loc = this.value;

//     if( loc == 'all' ) {
//         jobs.removeClass('d-none');
//     } else {
//         $(jobs).each( function(i, item) {
//             if( item.dataset.loc != loc ) {
//                 $(item).addClass('d-none');
//             } else {
//                 $(item).removeClass('d-none');
//             }
//         } );
//     }
// } );

// $('#reset-jobs').on('click', function(e) {
//     loc_filter.value = 'all';
//     jobs.removeClass('d-none');
// })