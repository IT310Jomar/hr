import jsPDF from 'jspdf';
import 'jspdf-autotable';

//FUNCTION FOR EXPORTING TO PDF
export function generatePdf (tableRef: any) {
  const doc = new jsPDF();
  const data = [tableRef];
  const table = data[0].$el.querySelector('table');
  const thead = table.querySelector('thead');

  // Add title to the PDF
  const title = 'Sirius - Attendance Management';
  const titleX = doc.internal.pageSize.getWidth() / 2;
  doc.setFont('helvetica', 'bold');
  doc.text(title, titleX, 15, { align: 'center' });

  // Get table rows and calculate total hours
  const rows = table.querySelectorAll('tbody tr');
  let totalHours = 0;
  for (let i = 0; i < rows.length; i++) {
    const row = rows[i];
    const hours = row.cells[4].innerText;
    const [hoursStr, minutesStr] = hours.split(':');
    const hoursNum = Number(hoursStr);
    const minutesNum = Number(minutesStr);
    totalHours += hoursNum + (minutesNum / 60);
  }

  // Add table to the PDF
  doc.autoTable({
    html: table,
    startY: 20, // adjust the startY position to leave space for the title
    margin: { top: 20, right: 10, bottom: 10, left: 10 },
    styles: {
      cellPadding: 2,
      fontSize: 12,
    },
    headStyles: {
      fillColor: '#ff6600',
      textColor: '#000000',
    },
  });
  // Add total hours to the PDF
  const totalHoursStr = `TOTAL HOURS: ${totalHours.toFixed(2)} hrs.`;
  doc.setFontSize(14);
  doc.setFont('Times New Roman', 'bold');
  doc.text(totalHoursStr, doc.internal.pageSize.getWidth() - 10, doc.autoTable.previous.finalY + 10, { align: 'right' });
  doc.save('table.pdf');
};
