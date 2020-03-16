
import {httpConfig} from "../misc/http-config";
import _ from "lodash";

export const getAllTags = () => async dispatch => {
	const {data} = await httpConfig(`/apis/tag/`);
	dispatch({type: "GET_ALL_TAGS", payload: data})
};

export const getTagByTagId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/tag/${id}`);
	dispatch({type: "GET_TAG_BY_TAG_ID", payload: data})
};