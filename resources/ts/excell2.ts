import * as XLSX from 'xlsx';

//FUNCTION FOR EXPORTING TO EXCEL
export function exportToExcel2( tableRef: any) {
  const data = [tableRef];
  const sheetName = 'Sheet1';
  const table = data[0].$el.querySelector('table');
  const thead = table.querySelector('thead');
  const tbody = table.querySelector('tbody');
  if (!table) {
    console.error('Table not found');
    return;
  }
  const wb = XLSX.utils.table_to_book(table, { sheet: sheetName });
  const worksheet = wb.Sheets[sheetName];
  const rows = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
  const columnWidths = rows.reduce((acc: any, row: any) => {
    row.forEach((cellValue: { toString: () => { (): any; new(): any; length: any; }; }, i: string | number) => {
      const maxLength = cellValue ? cellValue.toString().length : 0;
      const columnWidth = acc[i] || { width: 0 };
      if (maxLength > columnWidth.width) {
        columnWidth.width = maxLength;
        acc[i] = columnWidth;
      }
    });
    return acc;
  }, []);
  worksheet['!cols'] = columnWidths as XLSX.ColInfo[];
  XLSX.writeFile(wb, 'data.xlsx');
}
