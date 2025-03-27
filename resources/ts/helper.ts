import moment from "moment";

export function formatDate(dateString: moment.MomentInput) {
    const date = moment(dateString);
    return date.format("MMMM DD, YYYY");
}
