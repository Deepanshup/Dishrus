/* jshint esversion: 6 */
import {
	isMobile,
	neveEach,
	isIe,
	unhashUrl,
	toggleClass,
	removeClass,
	addClass
} from '../utils.js';

let pageUrl;

/**
 * Initialize nav logic.
 */
export const initNavigation = function() {
	pageUrl = window.location.href;
	repositionDropdowns();
	handleScrollLinks();
	handleMobileDropdowns();
	handleSearch();
	if ( isIe() === true ) {
		handleIeDropdowns();
	}
};

/**
 * Reposition drop downs in case they go off screen.
 * @returns {boolean}
 */
export const repositionDropdowns = function() {
	if ( isMobile() ) return false;

	let dropDowns = document.querySelectorAll( '.sub-menu .sub-menu' );
	if ( dropDowns.length === 0 ) return false;

	let windowWidth = window.innerWidth;
	neveEach( dropDowns, function(dropDown) {
		let bounding = dropDown.getBoundingClientRect(),
				rightDist = bounding.left;
		if ( /webkit.*mobile/i.test( navigator.userAgent ) ) {
			bounding -= window.scrollX;
		}

		if ( rightDist + bounding.width >= windowWidth ) {
			dropDown.style.right = '100%';
			dropDown.style.left = 'auto';
		}
	} );
};

/**
 * Handle links that link to the current page.
 * @returns {boolean}
 */
function handleScrollLinks() {
	let links = document.querySelectorAll( '.nv-nav-wrap a' );
	if ( links.length === 0 ) return false;

	neveEach( links, function(link) {
		link.addEventListener( 'click', function(event) {
			let href = event.target.getAttribute( 'href' );
			if ( href === null ) return false;
			if ( unhashUrl( href ) === unhashUrl( pageUrl ) ) {
				window.HFG.toggleMenuSidebar(false);
			}
		} );
	} );
}

/**
 * Handle dropdowns on mobile devices.
 */
function handleMobileDropdowns() {
	let carets = document.querySelectorAll( '.caret-wrap' );
	neveEach( carets, function(caret) {
		caret.addEventListener( 'click', function(event) {
			event.preventDefault();
			let subMenu = caret.parentNode.parentNode.querySelector( '.sub-menu' );
			toggleClass( caret, 'dropdown-open' );
			toggleClass( subMenu, 'dropdown-open' );
		} );
	} );
}

/**
 * Handle searches.
 */
function handleSearch() {
	let navSearch = document.querySelectorAll( '.nv-nav-search' ),
			navItem = document.querySelectorAll( '.menu-item-nav-search' ),
			close = document.querySelectorAll( '.close-responsive-search' ),
			html = document.querySelector( 'html' );
	// Handle search opening.
	neveEach( navItem, function(searchItem) {
		searchItem.addEventListener( 'click', function(e) {
			e.stopPropagation();
			toggleClass( searchItem, 'active' );
			searchItem.querySelector( '.search-field' ).focus();
			if ( !isMobile() ) {
				createNavOverlay( searchItem, 'active' );
			}
		} );
	} );
	// Don't close thee search if interacted with.
	neveEach( navSearch, function(item) {
		item.addEventListener( 'click', function(e) {
			e.stopPropagation();
		} );
	} );
	// Mobile search close buttons.
	neveEach( close, function(button) {
		button.addEventListener( 'click', function(e) {
			e.preventDefault();
			neveEach( navItem, function(search) {
				removeClass( search, 'active' );
			} );
			let overlay = document.querySelector( '.nav-clickaway-overlay' );
			if ( overlay === null )
				return;
			overlay.parentNode.removeChild( overlay );
		} );
	} );
}

/**
 * Create an overlay to allow closing.
 *
 * @param item
 * @param classToRemove
 * @param multiple
 * @returns {boolean}
 */
function createNavOverlay(item, classToRemove, multiple = false) {

	let navClickaway = document.querySelector( '.nav-clickaway-overlay' );
	if ( navClickaway !== null ) {
		return false;
	}
	navClickaway = document.createElement( 'div' );
	addClass( navClickaway, 'nav-clickaway-overlay' );

	let primaryNav = document.querySelector( 'header.header' );
	primaryNav.parentNode.insertBefore( navClickaway, primaryNav );

	navClickaway.addEventListener( 'click', function() {
		removeClass( item, classToRemove );
		navClickaway.parentNode.removeChild( navClickaway );
	} );
}

/**
 * Handle dropdowns for special browsers that...
 * have trouble understanding what hover is.
 */
function handleIeDropdowns() {
	let dropdowns = document.querySelectorAll(
			'.header--row[data-show-on="desktop"] .sub-menu' );
	neveEach( dropdowns, function(dropdown) {
		let parentItem = dropdown.parentNode;

		parentItem.addEventListener( 'mouseenter', function() {
			addClass( dropdown, 'dropdown-open' );
		} );
		parentItem.addEventListener( 'mouseleave', function() {
			removeClass( dropdown, 'dropdown-open' );
		} );
	} );
}

