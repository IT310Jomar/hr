
import type { Except } from 'type-fest';

export interface Event {
  id: string
  url: string
  title: string
  start: any
  end: any
  allDay: boolean
  extendedProps: {
    calendar?: string
    location: string
    description: string
    user_level: any[],
  }
}
export type NewEvent = Except<Event, 'id', 'url'>

