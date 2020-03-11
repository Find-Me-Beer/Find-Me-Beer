
import {httpConfig} from "../misc/http-config";
import _ from "lodash";

export const getBeer = () => async dispatch => {
	const {data} = await httpConfig(`/apis/beer/`);
	dispatch({type: "GET_ALL_BEER", payload: data})
};


