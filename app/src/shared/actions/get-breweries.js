
import {httpConfig} from "../misc/http-config";
import _ from "lodash";

export const getAllBreweries = () => async dispatch => {
	const {data} = await httpConfig(`/apis/brewery/`);
	dispatch({type: "GET_ALL_BREWERIES", payload: data})
};
