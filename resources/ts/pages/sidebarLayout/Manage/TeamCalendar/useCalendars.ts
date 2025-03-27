import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import type {
  CalendarApi,
  CalendarOptions,
  EventApi,
  EventSourceFunc,
} from "@fullcalendar/vue3";
import type { Ref } from "vue";
import type { Events, NewEvents } from "./Teamtypes";
import { useThemeConfig } from "@core/composable/useThemeConfig";
// import { useCalendarStore } from '@/pages/admin/company/calendar/useCalendarStore'
import { useCalendarStores} from "./useCalendarStores";

const isLoading = ref(false) 
//  const emit = defineEmits(["eventAfterAllRender"]);
export const blankEvent = {
  id: "",
  title: "",
  start: "",
  end: "",
  url: "",
  allDay: false,
  extendedProps: {
    /*
      ℹ️ We have to use undefined here because if we have blank string as value then select placeholder will be active (moved to top).
      Hence, we need to set it to undefined or null
    */
    // calendar: undefined,
    
    calendar: "",
    reason: "",
    employee_id :null
  },
};

export const useCalendars = (
  event: Ref<Events | NewEvents>,
  isEventHandlerSidebarActive: Ref<boolean>,
  isLeftSidebarOpen: Ref<boolean>
) => {
  // 👉 themeConfig
  const { isAppRtl } = useThemeConfig();

  // 👉 Store
  const store = useCalendarStores();

  // 👉 Calendar template ref
  const refCalendar = ref();

  // 👉 Calendar colors
  const calendarsColor = {
    Business: "info",
    Leave: "success",
  };

  // ℹ️ Extract event data from event API
  const extractEventDataFromEventApi = (eventApi: EventApi) => {
    // @ts-expect-error EventApi has extendProps type Dictionary (Record<string, any>) and we have fully typed extended props => Type conflict
    const {
      id,
      title,
      start,
      end,
      url,
      extendedProps: { employee_id, calendar, reason },
      allDay,
    }: Events = eventApi;

    return {
      id,
      title,
      start,
      end,
      url,
      extendedProps: {
        employee_id,
        calendar,
        reason,
      },
      allDay,
    };
  };
  // 👉 Fetch events
  const fetchEvents: EventSourceFunc = (info, successCallback) => {
    // If there's no info => Don't make useless API call
    if (!info) return;
    let isLoading = true;
    store
      .fetchEvents()
      .then((response) => {
        successCallback(
          response.data.events.map((e: Events) => ({
            ...e,
            // Convert string representation of date to Date object
            start: new Date(e.start),
            end: new Date(e.end),
          }))
        );
      })
      .catch((e) => {
        console.error("Error occurred while fetching calendar events", e);
      });
  };

  // 👉 Calendar API
  const calendarApi = ref<null | CalendarApi>(null);

  // 👉 Update event in calendar [UI]
  const updateEventInCalendar = (
    updatedEventData: Events,
    propsToUpdate: (keyof Events)[],
    extendedPropsToUpdate: (keyof Events)[]
  ) => {
    const existingEvent = calendarApi.value?.getEventById(updatedEventData.id);
    if (!existingEvent) {
      console.warn("Can't found event in calendar to update");
      return;
    }

    // ---Set event properties except date related
    // Docs: https://fullcalendar.io/docs/Event-setProp
    // dateRelatedProps => ['start', 'end', 'allDay']
    for (let index = 0; index < propsToUpdate.length; index++) {
      const propName = propsToUpdate[index];

      existingEvent.setProp(propName, updatedEventData[propName]);
    }

    // --- Set date related props
    // ? Docs: https://fullcalendar.io/docs/Event-setDates
    existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
      allDay: updatedEventData.allDay,
    });

    // --- Set event's extendedProps
    // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp

    for (var index = 0; index < extendedPropsToUpdate.length; index++) {
      const propName = extendedPropsToUpdate[index];
      existingEvent.setExtendedProp(propName, updatedEventData[propName]);
    }
  };

  // 👉 Remove event in calendar [UI]
  const removeEventInCalendar = (eventId: string) => {
    const _event = calendarApi.value?.getEventById(eventId);

    if (_event) _event.remove();
  };

  // 👉 refetch events
  const refetchEvents = () => {
    calendarApi.value?.refetchEvents();
    // console.log(store.selectedCalendars, 'refetch Event')
  };

  watch(() => store.selectedCalendars, refetchEvents);

  // 👉 Add event
  const addEvent = (_event: NewEvents) => {
    store.addEvent(_event).then((response) => {
      console.log(response.data);
      refetchEvents();
    });
  };
  // 👉 Update event
  const updateEvent = (_event: Events) => {
    store.updateEvent(_event).then((response) => {
      const propsToUpdate = [
        "id",
        "title",
        "start",
        "end",
        "allDay",
      ] as (keyof Events)[];
      const extendedPropsToUpdate = [
        "calendar",
        "reason",
        "employee_id",
      ] as unknown as (keyof Events)[];
      updateEventInCalendar(
        response.data.updateEvent,
        propsToUpdate,
        extendedPropsToUpdate
      );
    });
  };

  // 👉 Remove event
  const removeEvent = (eventId: string) => {
    store.removeEvent(eventId).then(() => {
      removeEventInCalendar(eventId);
    });
  };

  // 👉 Calendar options
  const calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
      start: "drawerToggler,prev,next title",
      end: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
    },
    events: fetchEvents,

    // ❗ We need this to be true because when its false and event is allDay event and end date is same as start data then Full calendar will set end to null
    forceEventDuration: true,

    /*
    Enable dragging and resizing event
    Docs: https://fullcalendar.io/docs/editable
  */
    editable: true,

    /*
    Enable resizing event from start
    Docs: https://fullcalendar.io/docs/eventResizableFromStart
  */
    eventResizableFromStart: true,

    /*
    Automatically scroll the scroll-containers during event drag-and-drop and date selecting
    Docs: https://fullcalendar.io/docs/dragScroll
  */
    dragScroll: true,

    /*
    Max number of events within a given day
    Docs: https://fullcalendar.io/docs/dayMaxEvents
  */
    dayMaxEvents: 2,

    /*
    Determines if day names and week names are clickable
    Docs: https://fullcalendar.io/docs/navLinks
  */
    navLinks: true,

    eventClassNames({ event: calendarEvent }) {
      const colorName =
        calendarsColor[
          calendarEvent._def.extendedProps
            .calendar as keyof typeof calendarsColor
        ];

      return [
        // Background Color
        `bg-light-${colorName} text-${colorName}`,
      ];
    },

    eventClick({ event: clickedEvent }) {
      // * Only grab required field otherwise it goes in infinity loop
      // ! Always grab all fields rendered by form (even if it get `undefined`) otherwise due to Vue3/Composition API you might get: "object is not extensible"
      event.value = extractEventDataFromEventApi(clickedEvent);
      isEventHandlerSidebarActive.value = true;
    },

    // customButtons
    dateClick(info) {
      event.value = { ...event.value, start: new Date(info.date) };
      isEventHandlerSidebarActive.value = true;
    },

    /*
      Handle event drop (Also include dragged event)
      Docs: https://fullcalendar.io/docs/eventDrop
      We can use `eventDragStop` but it doesn't return updated event so we have to use `eventDrop` which returns updated event
    */
    eventDrop({ event: droppedEvent }) {
      updateEvent(extractEventDataFromEventApi(droppedEvent));
    },

    // /*
    //   Handle event resize
    //   Docs: https://fullcalendar.io/docs/eventResize
    // */
    eventResize({ event: resizedEvent }) {
      if (resizedEvent.start && resizedEvent.end)
        updateEvent(extractEventDataFromEventApi(resizedEvent));
    },

    customButtons: {
      drawerToggler: {
        text: "calendarDrawerToggler",
        click() {
          isLeftSidebarOpen.value = true;
        },
      },
    },
  } as CalendarOptions;

  // 👉 onMounted
  onMounted(() => {
    calendarApi.value = refCalendar.value.getApi();
    isLoading.value = true;
  });

  // 👉 Jump to date on sidebar(inline) calendar change
  const jumpToDate = (currentDate: string) => {
    calendarApi.value?.gotoDate(new Date(currentDate));
  };

  watch(
    isAppRtl,
    (val) => {
      calendarApi.value?.setOption("direction", val ? "rtl" : "ltr");
    },
    { immediate: true }
  );

  return {
    isLoading,
    refCalendar,
    calendarOptions,
    refetchEvents,
    fetchEvents,
    addEvent,
    updateEvent,
    removeEvent,
    jumpToDate,
  };
};
