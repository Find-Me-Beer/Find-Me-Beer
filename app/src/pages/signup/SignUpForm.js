import React, {useState} from 'react';
import {httpConfig} from "../../shared/misc/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";
import {useHistory} from "react-router-dom";

export const SignUpForm = ({handleClose}) => {
	const history = useHistory();
	const signUp = {
		signupUsername: "",
		signupEmail: "",
		signupFullName: "",
		signupPassword: "",
		signupPasswordConfirm: ""
	};


	const validator = Yup.object().shape({
		signupEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		signupUsername: Yup.string()
			.required("user name is required"),
		signupFullName: Yup.string()
			.required("user's full name is required"),
		signupPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		signupPasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
	});

	const submitSignUp = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					if(reply.status === 200) {
						resetForm();
						handleClose();
						history.push("/sign-up-successful")
					} setStatus({message, type});
				}
			);
	};


	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};