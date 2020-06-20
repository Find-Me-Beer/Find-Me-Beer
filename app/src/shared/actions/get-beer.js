
import {httpConfig} from "../misc/http-config";
import _ from "lodash";
import {getBreweryByBreweryId} from "./get-breweries";
import {getAllTags} from "./get-tag";
import {getBeerTagsByBeerTagBeerId, getBeerTagsByBeerTagTagId} from "./get-beerTag";
import {getUserByUserId} from "./get-user";

export const getAllBeer = () => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/`);
	dispatch({type: "GET_ALL_BEER", payload: data})
};

export const getBeerByBeerId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/${id}`);
	dispatch({type: "GET_BEER_BY_BEER_ID", payload: data})
};

export const getBeerByBeerBreweryId = (beerBreweryId) => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/?beerBreweryId=${beerBreweryId}`);
	dispatch({type: "GET_BEER_BY_BEER_BREWERY_ID", payload: data})
};

export const getBeerByBeerType = (beerType) => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/?beerType=${beerType}`);
	dispatch({type: "GET_BEER_BY_BEER_TYPE", payload: data})
};

export const getBeerByTagId = (tagId) => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/?tagId=${tagId}`);
	dispatch({type: "GET_BEER_BY_BEER_TAG_ID", payload: data})
};

export const getTagsAndBeerTags = () => async (dispatch, getState) => {
	await dispatch(getAllTags());
	const beerIds = _.uniq(_.map(getState().beer, "beerId"));
	beerIds.forEach(id => dispatch(getBeerTagsByBeerTagBeerId(id)));
};

export const getEverythingButFavorites = () => async (dispatch, getState) => {
	await dispatch(getAllBeer());

	await dispatch(getAllTags());
	const beerIds = _.uniq(_.map(getState().beer, "beerId"));
	beerIds.forEach(id => dispatch(getBeerTagsByBeerTagBeerId(id)));

	const breweryIds = _.uniq(_.map(getState().beer, "beerBreweryId"));
	breweryIds.forEach(id => dispatch(getBreweryByBreweryId(id)));
};

export const getBeerAndUsers = () => async (dispatch, getState) => {
	await dispatch(getAllBeer());

	const userIds = _.uniq(_.map(getState().beer, "beerUserId"));
	userIds.forEach(id => dispatch(getUserByUserId(id)));
};