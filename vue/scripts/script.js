const BASE_URL = getBaseUrl();
const COLUMN_CLASS = "column";
const MODULE_TITRE = "module";
const MODULE_TOTAL_TITRE = "Total";
const TOTAL_CLASS = "columnTot";
const TOTAL_MODULE_FOR_COURSE = "mod";
const MODULE_CLASS_TITLE = "module";
const COURSE_CLASS_TITLE = "course";
const PERIOD_TOTAL_ID = "lineTot";
const STATUS_SUCCESS = "success";
const STATUS_FAILED_MESSAGE = "HTTP_REQUEST failed.";

/**
 * --------------------------------------------------------------------------------------------------------------------------
 * ------------------------------------------------ FUNCTIONS ---------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------------
 */

/**
 * Initialize the page
 */
$(document).ready(function () {
    initialize();
    $('.fa-trash-alt').droppable({
        drop: function (event, ui) {
            calculateCourseTotal(ui.draggable.parent().parent().attr('id'), ui.draggable.html());
            calculatePeriodeTotal(ui.draggable.parent().attr('class'), ui.draggable.html());
            calculateModuleTotal(ui.draggable.parent().parent().children().last().attr('class'), true);
            ui.draggable.remove();
        }
    });
    $('.white').on('click',function(){
        $("#button_modal").trigger('click');
    });
});

/**
 * Add time for a course
 */
$(document).on('click', '.white', function () {
    //TODO: Replace this by a custom dialog box w/ JQuery
    let placeholder = "";
    let hours = "";
    if ($(this).html() != "") { placeholder = $(this).children().text(); }
    if (placeholder != "") {
        hours = prompt("Saisissez le nombre d'heures que vous souhaitez", placeholder);
    } else {
        hours = prompt("Saisissez le nombre d'heures que vous souhaitez");
    }
    if (hours != null) {
        addHours($(this), hours);
        $('.white').droppable({
            drop: function (event, ui) {
                swapHours($(this), ui.draggable, ui.draggable.parent());
            }
            /*,
            over: function(event, ui) {
                $(this).css('background', 'orange');
            },
            out: function(event, ui) {
                $(this).css('background', 'cyan');
            }*/
        });
    }
});

$(document).on('click', '#valid_horraire', function(){

})



/**
 * --------------------------------------------------------------------------------------------------------------------------
 * ------------------------------------------------ MAIN FUNCTIONS ----------------------------------------------------------
 * --------------------------------------------------------------------------------------------------------------------------
 */

/**
 * Function that initialize the timetable
 */
function initialize() {
    let nbColumn = 0;
    //Adding periods
    $.get(BASE_URL + "?controle=PeriodeController&action=index", function (data, status) {
        if (status == STATUS_SUCCESS) {
            let periods = JSON.parse(data);
            let periodsLength = periods.length;
            nbColumn = periodsLength + 1;
            initializeTitleTotalModuleColumn();
            for (p in periods) {
                let period = periods[p];
                initializePeriodColumn(periodsLength, period);
                initializeTotalPeriodLine(periodsLength);
                periodsLength--;
            }
        } else {
            alert(STATUS_FAILED_MESSAGE);
        }
    });
    //Adding Modules and courses
    $.get(BASE_URL + "?controle=ModuleController&action=index", function (data, status) {
        if (status == STATUS_SUCCESS) {
            let modules = JSON.parse(data);
            for (let m in modules) {
                let module = modules[m];
                initializeModuleLine(module, nbColumn);
                $.get(BASE_URL + "?controle=MatiereController&action=showByModule&id=" + module.id, function (data, status) {
                    if (status == STATUS_SUCCESS) {
                        let courses = JSON.parse(data);
                        for (let c in courses) {
                            let course = courses[c];
                            initializeCourseLine(course, module.id, nbColumn);
                            initializeTotalModuleColumn(module.id, course.id);
                        }
                    } else {
                        alert(STATUS_FAILED_MESSAGE);
                    }
                });
                initializeTotalModuleColumn(module.id, null);
            }
            $.get(BASE_URL + "?controle=ModuleController&action=index", function(data, status) {
                var object = JSON.parse(data);
                for (var o in object) {
                    var item = object[o];
                    $('#select_module').append('<option id=' + item.id + '>' + item.nom + '</option>');
                }
            });
        } else {
            alert(STATUS_FAILED_MESSAGE);
        }
    });


    $('#select_module').on('change',function(){
        var id = $(this).children(":selected").attr("id");
        $('#label_matiere').css("display", "block");
        $("#nom_matiere").css("display", "block");
        $('#label_label').css("display", "block");
        $("#lab_matiere").css("display", "block");
        $('#form_create_mat').append("<input name='id_mod' value='" + id + "' hidden />");
        var hexa = Math.floor( Math.random() * 0xFFFFFF );
        var result_hexa = "#" + hexa.toString(16);
        $('#form_create_mat').append("<input name='color_mat' value='" + result_hexa + "' hidden />");
    });
};


/**
 * ---------------------------------------------------------------------------------------------------------------------
 * ------------------------------------------------ BASIC FUNCTIONS ----------------------------------------------------------
 * ---------------------------------------------------------------------------------------------------------------------
 */

/**
 * Function that adds hours in a div
 * @param {*} div 
 * @param {*} hours 
 */
function addHours(div, hours) {
    let rgb = div.parent().children().css('background-color');
    if (div.html() != '') {
        div.html('');
        div.append('<p class="draggable" >' + hours + '</p>');
    } else {
        div.append('<p class="draggable">' + hours + '</p>');
    }
    calculateCourseTotal(div.parent().attr('id'), null);
    calculateModuleTotal(div.parent().children().last(), null);
    calculatePeriodeTotal(div, null);
    setDraggable(div.children(), rgbToHex(rgb));
}

/**
 * Function that convert rgb to hex
 * Source: https://stackoverflow.com/questions/1740700/how-to-get-hex-color-value-rather-than-rgb-value
 * @param {*} rgb 
 */
function rgbToHex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}
/**
 * Function that swaps hours in between course's div
 * @param {*} div_drop //Where to drop
 * @param {*} div_drag //From where to p comes to
 * @param {*} div_drag_parent 
 */
function swapHours(div_drop, div_drag, div_drag_parent) {
    //BackUp of the place where we gonna drop
    let drop_html = div_drop.text();
    let div_drop_to_send = div_drop;
    let rgb = div_drop.parent().children().css('background-color');
    div_drop.html('');
    div_drop.append('<p class="draggable" >' + div_drag.text() + '</p>');
    setDraggable(div_drop.children(), rgbToHex(rgb));

    //Here is the swap, only if the target div (where the div is dropped) is not empty
    let div_drag_to_send = div_drag_parent;
    if (drop_html != null) {
        div_drag_parent.html('');
        div_drag_parent.append('<p class="draggable" >' + drop_html + '</p>');
    }
    rgb = div_drag_parent.parent().children().css('background-color');
    div_drag.remove();
    setDraggable(div_drag_parent.children(), rgbToHex(rgb));
    calculateCourseTotal(div_drop.parent().attr('id'), null);
    calculateCourseTotal(div_drag_parent.parent().attr('id'), null);
    calculatePeriodeTotal(div_drag_to_send, null);
    calculatePeriodeTotal(div_drop_to_send, null);
}

/**
 * Function that sets the newly created div in the draggable mode
 */
function setDraggable(p, color) {
    p.draggable();
    p.css('background', color);
}
/**
 * Function that return the div of a clickable element
 * @param {*} div 
 */
function getLine(div) {
    return div.parent().attr('id');
}

/**
 * Function that returns the column
 * @param {*} div 
 */
function getColumn(div) {
    let classes = div.attr('class').split(/\s+/);
    let res = null;
    $.each(classes, function (index, item) {
        if (item.startsWith(COLUMN_CLASS)) {
            res = item;
        }
    });
    return res;
}

/**
 * Function that calculates the total for a course
 * @param {*} id 
 */
function calculateCourseTotal(id, minus) {

    let total = 0;

    $('#' + id + " .white p").each(function () {
        if ($(this).html() != "") {
            total = total + parseInt($(this).html());
        }
    });
    if (isNaN(total)) { total = 0 };
    if (minus != null) {
        if (total >= minus) { total = total - parseInt(minus) }
    }
    $('.' + TOTAL_CLASS + '-' + COURSE_CLASS_TITLE + '-' + id).html(total);
}

function calculateModuleTotal(div, mode) {
    let total = 0;
    let lastClass = "";
    if (mode != null) { lastClass = div.split(' ').pop(); }
    else { lastClass = div.attr('class').split(' ').pop(); }

    id = lastClass.split('-')[1];
    $('.' + TOTAL_MODULE_FOR_COURSE + '-' + id).each(function () {
        total = total + parseInt($(this).html());
    });
    $('.' + TOTAL_CLASS + '-' + MODULE_CLASS_TITLE + '-' + id).html(total);
}

function calculatePeriodeTotal(div, mode) {
    let lastClass = "";
    let classList = null;
    if (mode == null) {
        classList = div.attr('class').split(/\s+/);
    } else {
        classList = div.split(/\s+/);
    }
    let pos = 0;
    if (classList.includes('ui-droppable')) {
        pos = classList.length - 2;
    }
    if (pos != 0) {
        lastClass = classList[pos];
    } else {
        lastClass = div.attr('class').split(' ').pop();
    }
    id = lastClass.split('-')[1];
    var total = 0;
    $('.' + COLUMN_CLASS + '-' + id).each(function () {
        if (typeof $(this).children().first().html() !== 'undefined') {
            if ($(this).children().first().html() != "") {
                total = total + parseInt($(this).children().first().html());
            }
        }
    });
    if (isNaN(total)) { total = 0; }
    if (mode != null) {
        if (total >= mode) { total = total - parseInt(mode) }
    }
    console.log(total);
    $('#' + PERIOD_TOTAL_ID + '-' + id).html(total);
}
/**
 * Function that initializes the period columns AND the total module column (only the title)
 * @param {*} id 
 * @param {*} period 
 * @param {*} tot 
 */
function initializePeriodColumn(id, period) {
    $('<div class="cellules titre lime text-center ' + COLUMN_CLASS + '-' + id + '">'
        + period.periode + ' (' + period.diff + ' sem)</div>').insertAfter($('#titre'));
}

/**
 * Function that initializes the total period lines
 * @param {*} id 
 */
function initializeTotalPeriodLine(id) {
    $('<div class="cellules total silver text-center" id=' + PERIOD_TOTAL_ID +
        '-' + id + '>0</div>').insertAfter($('#' + PERIOD_TOTAL_ID));
}
/**
 * Function that initializes the total module column title
 */
function initializeTitleTotalModuleColumn() {
    $('<div class="cellules total silver text-center ' + TOTAL_CLASS + '"><p><b>'
        + MODULE_TOTAL_TITRE + '</b></p></div>').insertAfter($('#titre'));
}

/**
 * Function that initializes the total module in column
 * @param {*} id 
 */
function initializeTotalModuleColumn(id, course_id) {
    if (course_id == null) {
        $('#' + MODULE_TITRE + '-' + id).append('<div class="cellules total green text-center '
            + TOTAL_CLASS + '-' + MODULE_CLASS_TITLE + '-' + id + '">0</div>');
    } else {
        $('#' + course_id).append('<div class="cellules titre droppable text-center '
            + TOTAL_CLASS + '-' + COURSE_CLASS_TITLE + '-' + course_id + ' ' + TOTAL_MODULE_FOR_COURSE + '-' + id + '">0</div>');
    }
}

/**
 * Function that initializes the module lines
 * @param {*} module 
 */
function initializeModuleLine(module, nbColumn) {
    //Add title of the module on the line (first cell)
    $('<div class="row edt" id=' + MODULE_TITRE + '-' + module.id + '><div class="cellules titre droppable blue text-center">'+ module.nom + '</div>').insertAfter($('#H'));
    //Add non clickable div in the module line
    for (let i = 1; i < nbColumn; i++) {
        $('#' + MODULE_TITRE + '-' + module.id).append('<div class="cellules titre droppable silver text-center"></div>');
    }
}

function initializeCourseLine(course, module_id, nbColumn) {
    //Add title of course on the line
    let color = ""
    if (course.couleur != "") {
        color = course.couleur;
    } else {
        color = "#a55eea";
    }
    $('<div class="row edt" id=' + course.id + '><div class="cellules titre droppable text-center" style="background:' + color + '">'+ course.nom + '</div>').insertAfter($('#' + MODULE_TITRE + '-' + module_id));
    for (let i = 1; i < nbColumn; i++) {
        $('#' + course.id).append('<div class="cellules titre droppable white text-center ' + COLUMN_CLASS + '-' + i + '"></div>');
    }

}

/**
 * Function that returns the base url
 */
function getBaseUrl() {
    let baseurl = window.location.origin + window.location.pathname;
    if (baseurl.charAt(baseurl.length - 1) == "/") {
        baseurl = baseurl.slice(0, -1);
    }
    return baseurl;
}
