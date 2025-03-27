import type { Event, NewEvent } from './types'
import axios from '@axios'
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
export const useCalendarStore = defineStore('calendar', {
  // arrow function recommended for full type inference
  state: () => ({
    availableCalendars: [
      {
        color: 'info',
        label: 'For_90_Days_Review',
      },
      {
        color: '#BAFF29',
        label: 'For_180_Days_Review',
      },
      {
        color: 'warning',
        label: 'For_Annual_Review',
      },
      {
        color: 'success',
        label: 'Birthday',
      },
      {
        color: 'error',
        label: 'Leave',
      },
      {
        color: '#46237A',
        label: 'Official_Business',
      },
    ],
    selectedCalendars: ['For_90_Days_Review', 'For_180_Days_Review', 'For_Annual_Review', 'Birthday', 'Leave', 'Official_Business'],
  }),
  actions: {
    async fetchEvents() {
      return axios.get('/api/user/manage/manage-team/get-events', { params: { calendars: this.selectedCalendars , token: token } })
    },
    async addEvent(event: NewEvent) {
      return axios.post('/api/user/manage/manage-team/add-event', { event, token : token })
    },
    async updateEvent(event: Event) {
      return axios.post(`/api/user/manage/manage-team/update-events/${event.id}`,{ event , token: token })
    },
    async removeEvent(eventId: string) {
      return axios.delete(`/api/user/manage/manage-team/delete-event/${eventId}`, {params : {token : token}})
    },

  },
})
