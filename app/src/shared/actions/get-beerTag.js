
import {httpConfig} from "../misc/http-config";
import _ from "lodash";

export const getBeerTagsByBeerTagBeerId = (beerTagBeerId) => async dispatch => {
	const {data} = await httpConfig(`/apis/beerTag/?beerTagBeerId=${beerTagBeerId}`);
	dispatch({type: "GET_BEER_TAGS_BY_BEER_TAG_BEER_ID", payload: data})
};

export const getBeerTagsByBeerTagTagId = (beerTagTagId) => async dispatch => {
	const {data} = await httpConfig(`/apis/beerTag/?beerTagTagId=${beerTagTagId}`);
	dispatch({type: "GET_BEER_TAGS_BY_BEER_TAG_TAG_ID", payload: data})
};