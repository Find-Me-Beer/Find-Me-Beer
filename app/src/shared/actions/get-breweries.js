import {httpConfig} from "../misc/http-config";
import _ from "lodash";

export const getAllBreweries = () => async dispatch => {
	const {data} = await httpConfig(`/apis/brewery/`);
	dispatch({type: "GET_ALL_BREWERIES", payload: data})
};

export const getBreweryByBreweryId = (breweryId) => async dispatch => {
	const {data} = await httpConfig(`/apis/brewery/${breweryId}`);
	dispatch({type: "GET_BREWERY_BY_BREWERY_ID", payload: data})
};

export const getBreweryByLocation = (userLat, userLong, distance) => async dispatch => {
	const {data} = await httpConfig(`/apis/brewery/?breweryLocation=${userLat}&${userLong}&${distance}`);
	dispatch({type: "GET_BREWERY_BY_LOCATION", payload: data})
};

export const getBreweryByBreweryName = (breweryName) => async dispatch => {
	const {data} = await httpConfig(`/apis/brewery/?breweryName=${breweryName}`);
	dispatch({type: "GET_BREWERY_BY_BREWERY_NAME", payload: data})
};