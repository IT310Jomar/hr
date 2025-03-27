
import type { Except } from 'type-fest';

export interface Events {
  id: any
  url: string
  title: string
  start: any
  end: any
  allDay: boolean
  extendedProps: {
    calendar?: string
    reason: string
    employee_id: any[],
  }
}
export type NewEvents = Except<Events, 'id', 'url'>

