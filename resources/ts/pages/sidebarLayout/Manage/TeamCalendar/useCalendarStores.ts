import type { Events, NewEvents } from "./Teamtypes";
import axios from "@axios";
const token = JSON.parse(localStorage.getItem("accessToken") || "null");
export const useCalendarStores = defineStore("calendar", {
  // arrow function recommended for full type inference
  state: () => ({
    availableCalendars: [
      {
        color: "success",
        label: "Leave",
      },
      {
        color: "info",
        label: "Business",
      },
    ],
    selectedCalendars: ["Business", "Leave"],
  }),
  actions: {
    async fetchEvents() {
      return axios.get("/api/user/manage/manage-team/get-team-events", {
        params: { calendars: this.selectedCalendars, token: token },
      });
    },
    async addEvent(event: NewEvents) {
      return axios.post("/api/user/manage/manage-team/add-team-event", {
        event,
        token: token,
      });
    },
    async updateEvent(event: Events) {
      return axios.post(
        `/api/user/manage/manage-team/update-team-events/${event.id}`,
        { event, token: token }
      );
    },
    async removeEvent(eventId: string) {
      return axios.delete(
        `/api/user/manage/manage-team/delete-team-event/${eventId}`,
        { params: { token: token } }
      );
    },
  },
});
