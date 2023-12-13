! function(e) {
    "use strict";
    var t = function() {
        this.$body = e("body"),
        this.$modal = e("#event-modal"),
        this.$event = "#external-events div.external-event",
        this.$calendar = e("#calendar"),
        this.$saveCategoryBtn = e(".save-category"),
        this.$categoryForm = e("#add-category form"),
        this.$extEvents = e("#external-events"),
        this.$calendarObj = null
    };
    t.prototype.onDrop = function(t, n) {
        var a = t.data("eventObject"),
            o = t.attr("data-class"),
            i = e.extend({}, a);
        i.start = n,
        o && (i.className = [o]),
        this.$calendar.fullCalendar("renderEvent", i, !0),
        e("#drop-remove").is(":checked") && t.remove()
    }, t.prototype.onEventClick = function(t, n, a) {
        var o = this,
            i = e("<form></form>"),
            stats;

        this.$modal.find('.modal-title').html(t.title)

        switch (t.status) {
            case 'cancelled':
                stats = 'danger';
                break;
            case 'finished':
                stats = 'success';
                break;
            case 'full':
                stats = 'info';
                break;
            default:
                stats = 'primary';
                break;
        }
        var eventInfo = `<div>
                    <span class="badge badge-${t.category === 'cultural' ? 'info':'primary'}">${ t.category }</span>
                    <div class="my-3">${t.description}</div>
                    <small>Start At: ${ moment(t.start).format('YYYY-MM-DD @hh:mm a') }</small><br/>
                    <small>End At: ${ moment(t.end).format('YYYY-MM-DD @hh:mm a') }</small><br/>
                    <p>Status: <span class="badge badge-${stats}">${t.status}</span></p>
                </div>`;
        i.append(eventInfo),
        o.$modal.modal({
            backdrop: "static"
        }),
        o.$modal.find(".delete-event").show().end().find(".save-event").hide().end().find(".modal-body").empty()
            .prepend(i).end().find(".delete-event")
            .unbind("click")
            .on("click", function() {
                o.$calendarObj.fullCalendar("removeEvents", function(e) {
                    return e._id == t._id
                }),
                o.$modal.modal("hide")
        }),
        o.$modal.find("form").on("submit", function() {
            return t.title = i.find("input[type=text]").val(),
            o.$calendarObj.fullCalendar("updateEvent", t),
            o.$modal.modal("hide"),
            !1
        })
    },
    t.prototype.init = function() {
        var t = new Date,
            n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),
            a = [],
            o = this;

        initializeEvents(t, n, o, a)
    },
    e.CalendarApp = new t, e.CalendarApp.Constructor = t

    function initializeEvents(t, n, o, a) {
        fetch('events/all/json_type')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const response = data;
            response.forEach((el, key) => {

                let bg = 'default';
                switch (el.status) {
                    case 'cancelled':
                        bg = 'danger';
                        break;
                    case 'finished':
                        bg = 'success';
                        break;
                    case 'full':
                        bg = 'info';
                        break;
                    default:
                        bg = 'primary';
                        break;
                }

                a.push({
                    id: el.id,
                    title: el.name,
                    start: el.start_date,
                    end: el.end_date,
                    description: el.description,
                    status: el.status,
                    category: el.category,
                    className: `bg-${bg} text-white`
                });
            });

            o.$calendarObj = o.$calendar.fullCalendar({
                minTime: "01:00:00",
                maxTime: "23:00:00",
                defaultView: "month",
                handleWindowResize: !0,
                height: e(window).height() - 200,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "month,agendaWeek,agendaDay"
                },
                events: a,
                editable: !0,
                selectable: !0,
                drop: function(t) {
                    o.onDrop(e(this), t)
                },
                eventClick: function(e, t, n) {
                    o.onEventClick(e, t, n)
                },
                eventRender: function(event, element) {
                    // Customize the time format
                    var formattedStartTime = moment(event.start).format('hh:mm a');

                    // Update the HTML for each event
                    element.find('.fc-time').html(`<i class="fa fa-clock"></i> ${formattedStartTime}`);
                }
            })
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
    }

}(window.jQuery),
function(e) {
    "use strict";
    e.CalendarApp.init()
}(window.jQuery);
