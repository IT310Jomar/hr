import type { HorizontalNavItems } from '@layouts/types'
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router'
import { useToastr } from '@/toastr'

export default [
  //SystemAndHrAdmin
  {
    title: 'Dashboard',
    to: { name: 'index' },
    icon: { icon: 'tabler-home' },
    subject: 'SystemAndHrAdmin',
  },

  //ManagerSupervisor
  {
    title: 'Dashboard',
    to: { name: 'index' },
    icon: { icon: 'tabler-home' },
    subject: 'ManagerSupervisor',
  },

  //Employee
  {
    title: 'Dashboard',
    to: { name: 'index' },
    icon: { icon: 'tabler-home' },
    subject: 'Employee',
  },
  {
    title: 'MyRequest',
    to: { name: 'MyRequest' },
    icon: { icon: 'tabler-archive' },
    subject: 'AdminAndEmployee',
    action: 'manage',
    children: [
      {
        title: 'Cash Advance',
        to: 'sidebarLayout-cash_advance-CashAdvance',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Sick/Vaction Leave',
        to: 'sidebarLayout-sick_vacation_leave-SickVacationLeave',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Certificate of Attendance',
        to: 'sidebarLayout-certificate_of_advance-CertificateOfAdvance',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Schedule Adjustment',
        to: 'sidebarLayout-schedule_adjustment-ScheduleAdjustment',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Overtime',
        to: 'sidebarLayout-overtime-Overtime',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Undertime',
        to: 'sidebarLayout-undertime-Undertime',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
      {
        title: 'Official Business',
        to: 'sidebarLayout-official_business-OfficialBusiness',
        subject: 'AdminAndEmployee',
        action: 'manage',
      },
    ],
  },

  //SystemAndHrAdmin
  {
    title: 'MyRequest',
    to: { name: 'MyRequest' },
    icon: { icon: 'tabler-archive' },
    subject: 'SystemAndHrAdmin',
    action: 'manage',
    children: [
      {
        title: 'Cash Advance',
        to: 'sidebarLayout-cash_advance-CashAdvance',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Sick/Vaction Leave',
        to: 'sidebarLayout-sick_vacation_leave-SickVacationLeave',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Certificate of Attendance',
        to: 'sidebarLayout-certificate_of_advance-CertificateOfAdvance',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Schedule Adjustment',
        to: 'sidebarLayout-schedule_adjustment-ScheduleAdjustment',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Overtime',
        to: 'sidebarLayout-overtime-Overtime',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Undertime',
        to: 'sidebarLayout-undertime-Undertime',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Official Business',
        to: 'sidebarLayout-official_business-OfficialBusiness',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
    ],
  },

  //ManagerSupervisor
  {
    title: 'MyRequest',
    to: { name: 'MyRequest' },
    icon: { icon: 'tabler-archive' },
    subject: 'ManagerSupervisor',
    action: 'manage',
    children: [
      {
        title: 'Cash Advance',
        to: 'sidebarLayout-cash_advance-CashAdvance',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Sick/Vaction Leave',
        to: 'sidebarLayout-sick_vacation_leave-SickVacationLeave',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Certificate of Attendance',
        to: 'sidebarLayout-certificate_of_advance-CertificateOfAdvance',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Schedule Adjustment',
        to: 'sidebarLayout-schedule_adjustment-ScheduleAdjustment',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Overtime',
        to: 'sidebarLayout-overtime-Overtime',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Undertime',
        to: 'sidebarLayout-undertime-Undertime',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
      {
        title: 'Official Business',
        to: 'sidebarLayout-official_business-OfficialBusiness',
        subject: 'ManagerSupervisor',
        action: 'manage',
      },
    ],
  },
  {
    title: 'My Team',
    icon: { icon: 'tabler-users' },
    subject: 'AdminAndManager',
    action: 'manage',
    children: [
      {
        title: 'Manage Team',
        to: 'sidebarLayout-Manage-manage',
        subject: 'AdminAndManager',
        action: 'manage',
      },
      {
        title: 'Resolution Center',
        to: 'sidebarLayout-Resolution-resolution',
        subject: 'AdminAndManager',
        action: 'manage',
      },
      {
        title: 'Approval Center',
        to: 'sidebarLayout-Approval-approval',
        subject: 'AdminAndManager',
        action: 'manage',
      },
    ],
  },

  //SystemAndHrAdmin
  {
    title: 'My Team',
    icon: { icon: 'tabler-users' },
    subject: 'SystemAndHrAdmin',
    action: 'manage',
    children: [
      {
        title: 'Manage Team',
        to: 'sidebarLayout-Manage-manage',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Resolution Center',
        to: 'sidebarLayout-Resolution-resolution',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
      {
        title: 'Approval Center',
        to: 'sidebarLayout-Approval-approval',
        subject: 'SystemAndHrAdmin',
        action: 'manage',
      },
    ],
  },

  //SystemAndHrAdmin
  {
    title: 'Logout',
    icon: { icon: 'tabler-logout' },
    to: { name: 'sidebarLayout-logout'},
    subject: 'SystemAndHrAdmin',
    action: 'manage',
  },

  //ManagerSupervisor
  {
    title: 'Logout',
    icon: { icon: 'tabler-logout' },
    to: { name: 'sidebarLayout-logout'},
    subject: 'ManagerSupervisor',
    action: 'manage',
  },

  //Employee
  {
    title: 'Logout',
    icon: { icon: 'tabler-logout' },
    to: { name: 'sidebarLayout-logout'},
    subject: 'Employee',
    action: 'manage',
  },

] as HorizontalNavItems
