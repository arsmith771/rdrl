/**
 *
 * Add .js class to body tag if JavaScript is enabled
 *
 * @since 1.0.0
 *
 */
document.getElementsByTagName('body')[0].className += ' js';

function showHideFilter(){

	var trigger = jQuery('#projects-filter__toggle');

	trigger.on('click', function(){

		jQuery('.wpv-filter-form').toggle(300);
		jQuery(this).closest('#projects-filter').toggleClass('open');
		jQuery(this).toggleClass('open');

	});
}

function alignHeight(elem1, elem2, adjust){

	if ( ( jQuery(elem1).length > 0 ) && ( jQuery(elem2).length > 0 ) ) {

		var posY = jQuery(elem1).offset().top + adjust;

		console.log(posY);

		jQuery(elem2).css('top', posY + 'px');

	}
}


function checkboxes(){

	jQuery('#projects-filter__form-elements label input:checkbox').each(function(){

		var label = jQuery(this).closest('label');

        jQuery(this).insertBefore(label);

	});  
}

function matchID(elem){

	var entryID = jQuery('#genesis-content > .entry').attr('class'),
		menItem = jQuery(elem).find('.menu-item');

	menItem.each(function(){

		var menuID = jQuery(this).attr('id');

		if ( entryID.indexOf(menuID) !== -1 ) {

			jQuery(this).addClass('current-menu-item');
		}

	});
}

function showHideResponsiveMenu(){

	jQuery('#menu-toggle').on('click', function(){

		jQuery('#genesis-nav-primary').slideToggle();

	});
}

function resetMenu(){

	if ( jQuery('#menu-toggle').css('display') == 'none' ) {

		jQuery('#genesis-nav-primary, .sub-menu').removeAttr('style');

	}
}

function addSubToggleBtn(){

	jQuery('.sub-menu').each(function(){

		jQuery(this).before('<button class="sub-menu-toggle" />');

	});

}

function showHideSubMenuResp(){

	jQuery('.sub-menu-toggle').on('click', function(){

		jQuery(this).toggleClass('activated');
		jQuery(this).next('.sub-menu').slideToggle();

	});
}

function homeServiceMenu(){

	jQuery('#services-menu--home').appendTo('.site-header');
}

function quoteWidth(){

	var colWidth = jQuery('.single-projects .col-2').outerWidth();

	jQuery('.single-projects #quote').outerWidth(colWidth);

}

function pinFooter(){

	var footer = jQuery('.site-footer'),
		footerH = footer.outerHeight(),
		siteContainer = jQuery('.site-container'),
		winH = window.innerHeight,
		docH = jQuery('body').outerHeight();

		console.log(winH, docH);

		//if ( winH > ( docH + footerH ) ){
		if ( winH > docH ){

			footer.addClass('pinned');
			siteContainer.css('padding-bottom', footerH + 'px');

		} else {

			footer.removeClass('pinned');
			siteContainer.removeAttr('style');

		}
}

jQuery(document).ready( function() {

	homeServiceMenu();
	quoteWidth();
	showHideFilter();
	alignHeight('#block-1__img-container', '#quote', 30);
	checkboxes();
	matchID('.services-menu');
	matchID('.about-menu');
	showHideResponsiveMenu();
	addSubToggleBtn();
	showHideSubMenuResp();
	pinFooter();

});

jQuery(window).on('resize', function() {

	quoteWidth();
	alignHeight('#block-1__img-container', '#quote', 30);
	resetMenu();
	pinFooter();
});
