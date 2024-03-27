var $sidebar = $('.control-sidebar')
var $container = $('<div />', {
class: 'p-3 control-sidebar-content'
})
$sidebar.append($container)


$container.append(
'<h5>Customize Interface</h5><hr class="mb-2"/>'
)

// for dark mode
var $dark_mode_checkbox = $('<input />', {
type: 'checkbox',
value: 1,
checked: $('body').hasClass('dark-mode'),
class: 'mr-1'
}).on('click', function () {
if ($(this).is(':checked')) {
    $('body').addClass('dark-mode')
} else {
    $('body').removeClass('dark-mode')
}
})
var $dark_mode_container = $('<div />', { class: 'mb-4' }).append($dark_mode_checkbox).append('<span>Dark Mode</span>')
$container.append($dark_mode_container)

//for sidebar hover
var $sidebar_collapsed_checkbox = $('<input />', {
type: 'checkbox',
value: 1,
checked: $('body').hasClass('sidebar-collapse'),
class: 'mr-1'
}).on('click', function () {
if ($(this).is(':checked')) {
    $('body').addClass('sidebar-collapse')
    $(window).trigger('resize')
} else {
    $('body').removeClass('sidebar-collapse')
    $(window).trigger('resize')
}
})
var $sidebar_collapsed_container = $('<div />', { class: 'mb-4' }).append($sidebar_collapsed_checkbox).append('<span>Collapsed</span>')
$container.append($sidebar_collapsed_container)

// fixed header
var $header_fixed_checkbox = $('<input />', {
type: 'checkbox',
value: 1,
checked: $('body').hasClass('layout-navbar-fixed'),
class: 'mr-1'
}).on('click', function () {
if ($(this).is(':checked')) {
    $('body').addClass('layout-navbar-fixed')
} else {
    $('body').removeClass('layout-navbar-fixed')
}
})
var $header_fixed_container = $('<div />', { class: 'mb-4' }).append($header_fixed_checkbox).append('<span>Fixed</span>')
$container.append($header_fixed_container)