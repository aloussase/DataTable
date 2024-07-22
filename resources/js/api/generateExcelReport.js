import {saveAs} from 'file-saver';

export const generateExcelReport = async () => {
    saveAs('/api/reports/excel');
}
