import React, { useState } from "react";
import {
  Autocomplete,
  Checkbox,
  Chip,
  Dialog,
  DialogContent,
  FormControl,
  FormControlLabel,
  FormHelperText,
  Grid,
  InputLabel,
  MenuItem,
  Select,
  Stack,
  TextField,
} from "@mui/material";
import { makeStyles } from "@mui/styles";
import { Box, grid } from "@mui/system";
import {
  AddButton,
  PortionTitle,
  UploadFileButton,
} from "../../../styles/globalStyled";
import PublishIcon from "@mui/icons-material/Publish";
import { useDispatch, useSelector } from "react-redux";
import {
  addDoctor,
  fetchDoctor,
  fetchDoctors,
  toggleDoctorDialog,
  updateDoctor,
  uploadDoctorImage,
} from "../../../store/actions/doctorAction";
import { useEffect } from "react";
import {
  fetchAllDepartments,
  fetchDepartments,
} from "../../../store/actions/departmentAction";
import {
  FETCH_DOCTOR,
  TOGGLE_AUTH_VALIDATE_ERRORS,
} from "../../../store/types";
import UploadButton from "../shared/UploadButton";
import {
  fetchAllDivisions,
  fetchDivisions,
} from "../../../store/actions/divisionAction";
import _without from "lodash/without";
import { Close } from "@mui/icons-material";
import { fetchAllDistricts } from "../../../store/actions/districtAction";
import { fetchAllSubDistricts } from "../../../store/actions/subDistrictAction";

const AddDoctroDialog = () => {
  // const handleClose = () => setOpen(false);

  const dispatch = useDispatch();
  const departments = useSelector((state) => state.departmentStore.departments);
  console.log(departments);

  const allDepartments = useSelector(
    (state) => state.departmentStore.allDepartments
  );

  // all selected data gulo jate dialog ai fetch hoi sei jonno ekane fetch korlam..
  useEffect(() => {
    dispatch(fetchAllDepartments());
  }, [dispatch]);
  useEffect(() => {
    dispatch(fetchAllDivisions());
  }, [dispatch]);
  useEffect(() => {
    dispatch(fetchAllDistricts());
  }, [dispatch]);
  useEffect(() => {
    dispatch(fetchAllSubDistricts());
  }, [dispatch]);
  const allDivisions = useSelector((state) => state.divisionStore.allDivisions);

  const allDistricts = useSelector((state) => state.districtStore.allDistricts);

  const allSubDistricts = useSelector(
    (state) => state.subDistrictStore.allSubDistricts
  );

  const doctor = useSelector((state) => state.doctorsStore.doctor);

  // Add degree to box field..
  const [degree, setDegree] = useState("");
  const [degrees, setDegrees] = useState([]);
  const degreeChangeHandler = (e) => {
    if (e.keyCode === 13) {
      let existDegrees = [...degrees];
      existDegrees.push(e.target.value);
      setDegrees(existDegrees);
      setDegree("");
    }
  };
  const degreeKeyChangeHandler = (value) => {
    setDegree(value);
  };
  // ..............

  const handleCheckboxDelete = (index) => {
    console.log("Delete");
    console.log(index);
    let filterDegress = degrees.filter((item, i) => i !== index);
    console.log(filterDegress);
    setDegrees(filterDegress);
  };

  useEffect(() => {
    dispatch(fetchDepartments());
  }, [dispatch]);

  const [input, setInput] = useState({
    name: "",
    email: "",
    phone: "",
    password: "",

    workplace: "",
    department_id: "",

    degree: "",
    division_id: null,
    district_id: null,
    sub_district_id: null,
    doctor_fee: "",
    working_department_id: "",
    working_status: "None",
    image: "",
  });
  console.log(input);

  const [checked, setChecked] = React.useState("current");

  console.log(checked);

  const fieldChangeHandler = (field, value) => {
    // jodi adding ar somoi division field faka kori then district and subdistrict o khali hobe..

    if (field === "division_id") {
      setInput((prevState) => ({
        ...prevState,
        [field]: value,
        district_id: null,
        sub_district_id: null,
      }));
    } else if (field === "district_id") {
      setInput((prevState) => ({
        ...prevState,
        [field]: value,
        sub_district_id: null,
      }));
    } else {
      setInput((prevState) => ({
        ...prevState,
        [field]: value,
      }));
    }
  };

  const imageChangeHandler = (file) => {
    // let files = e.target.files;

    // if (files.length) {
    dispatch(
      uploadDoctorImage(file, (url) =>
        setInput((prevState) => ({
          ...prevState,
          image: url,
        }))
      )
    );
    // }
  };

  // console.log(input);

  // reset form a jakon dialog close and add or update submit hobe takon call hobe.
  // call korle input string gulo khali hoye jabe.
  const resetForm = () => {
    dispatch({
      type: FETCH_DOCTOR,
      payload: {},
    });
    dispatch(toggleDoctorDialog(false));

    dispatch({
      type: TOGGLE_AUTH_VALIDATE_ERRORS,
      payload: {
        validate_Errors: {},
      },
    });
    setInput(() => ({
      name: "",
      email: "",
      phone: "",
      password: "",

      workplace: "",
      department_id: "",

      degree: "",
      division_id: null,
      district_id: null,
      sub_district_id: null,
      doctor_fee: "",
      working_department_id: "",
      working_status: "None",
      image: "",
    }));

    dispatch(toggleDoctorDialog(false));
  };

  const handleSubmit = () => {
    // event.preventDefault();
    let formData = { ...input };
    formData["degree"] = degrees;

    // auto complete submit for division id..

    if (input.division_id && Object.keys(input.division_id).length > 0) {
      formData["division_id"] = input.division_id._id;
    }

    if (input.district_id && Object.keys(input.district_id).length > 0) {
      formData["district_id"] = input.district_id._id;
    }

    if (
      input.sub_district_id &&
      Object.keys(input.sub_district_id).length > 0
    ) {
      formData["sub_district_id"] = input.sub_district_id._id;
    }

    if (formData.hasOwnProperty("_id")) {
      dispatch(
        updateDoctor(formData, () => {
          dispatch(fetchDoctors());
          resetForm();
        })
      );
    } else {
      dispatch(
        addDoctor(formData, () => {
          dispatch(fetchDoctors());
          resetForm();
        })
      );
    }
  };

  // doctor value hoile and object paile then single edit option a single data show korbe.
  useEffect(() => {
    if (doctor && Object.keys(doctor).length > 0) {
      setInput((prevState) => ({
        ...prevState,
        ...doctor.user,
        ...doctor,
      }));
      setDegrees((prevState) => [...prevState, ...doctor.degree]);
    }
  }, [doctor]);

  const validateErrors = useSelector(
    (state) => state.authStore.validate_Errors
  );

  return (
    <>
      <Box xs={12} mb={5}>
        {input?._id ? (
          <PortionTitle variant="h6">Editing Doctor</PortionTitle>
        ) : (
          <PortionTitle variant="h6">Adding Doctor</PortionTitle>
        )}
      </Box>
      {/* <form> */}
      <Box xs={12}>
        <TextField
          id="outlined-basic"
          label="Full Name"
          variant="outlined"
          fullWidth
          value={input.name}
          onChange={(e) => fieldChangeHandler("name", e.target.value)}
          error={validateErrors?.name}
        />
        <FormHelperText id="component-error-text" error>
          {validateErrors?.name}
        </FormHelperText>
        <Box mt={2}>
          <TextField
            id="outlined-basic"
            label="Email"
            variant="outlined"
            fullWidth
            value={input.email}
            onChange={(e) => fieldChangeHandler("email", e.target.value)}
            error={validateErrors?.email}
          />
          <FormHelperText id="component-error-text" error>
            {validateErrors?.email}
          </FormHelperText>
        </Box>
        <Box mt={2}>
          <TextField
            id="outlined-basic"
            label="Mobile No"
            variant="outlined"
            inputProps={{ maxLength: 11 }}
            fullWidth
            value={input.phone}
            error={validateErrors?.phone}
            onChange={(e) => fieldChangeHandler("phone", e.target.value)}
          />
          <FormHelperText id="component-error-text" error>
            {validateErrors?.phone}
          </FormHelperText>
        </Box>

        {!input?._id && (
          <Box mt={2}>
            <TextField
              id="outlined-basic"
              label="Password"
              type="password"
              variant="outlined"
              fullWidth
              value={input.password}
              error={validateErrors?.password}
              onChange={(e) => fieldChangeHandler("password", e.target.value)}
            />
            <FormHelperText id="component-error-text" error>
              {validateErrors?.password}
            </FormHelperText>
          </Box>
        )}

        <Box mt={2}>
          <FormControl fullWidth>
            <InputLabel id="demo-simple-select-label">
              Add Department
            </InputLabel>
            <Select
              label="department"
              value={input.department_id}
              error={validateErrors?.department_id}
              onChange={(e) =>
                fieldChangeHandler("department_id", e.target.value)
              }
            >
              {allDepartments?.map((item) => (
                <MenuItem value={item._id}>{item.name}</MenuItem>
              ))}
            </Select>
          </FormControl>
        </Box>
        <FormHelperText id="component-error-text" error>
          {validateErrors?.department_id}
        </FormHelperText>

        <Box mt={2}>
          <TextField
            id="outlined-basic"
            label="Doctor's Fee"
            variant="outlined"
            fullWidth
            value={input.doctor_fee}
            error={validateErrors?.doctor_fee}
            onChange={(e) => fieldChangeHandler("doctor_fee", e.target.value)}
          />
        </Box>
        <FormHelperText id="component-error-text" error>
          {validateErrors?.doctor_fee}
        </FormHelperText>

        <Box mt={2}>
          <TextField
            label="Press enter to add degree"
            variant="outlined"
            fullWidth
            value={degree}
            error={validateErrors?.degree}
            onChange={(e) => degreeKeyChangeHandler(e.target.value)}
            onKeyDown={(e) => degreeChangeHandler(e)}
            // helperText={validateErrors?.degree[0]}
          />
          <Box>
            {degrees.map((item, i) => (
              <Chip
                key={i}
                label={item}
                onDelete={() => handleCheckboxDelete(i)}
              />
            ))}
          </Box>
        </Box>
        <FormHelperText id="component-error-text" error>
          {validateErrors?.degree}
        </FormHelperText>

        {!input?._id && (
          <>
            <Box mt={3} sx={{ display: "flex", justifyContent: "end" }}>
              <FormControlLabel
                label="Currently Working"
                // labelPlacement="right"
                control={
                  <Checkbox
                    checked={input.working_status === "Current" ? true : false}
                    onChange={(e) => {
                      if (e.target.checked) {
                        fieldChangeHandler("working_status", "Current");
                      } else {
                        fieldChangeHandler("working_status", "None");
                      }
                    }}
                  />
                }
              />
            </Box>
            <Box mt={2} mb={5}>
              <TextField
                label="Current Workplace"
                variant="outlined"
                fullWidth
                value={input.workplace}
                error={validateErrors?.workplace}
                onChange={(e) =>
                  fieldChangeHandler("workplace", e.target.value)
                }
              />
              <Stack direction="row" spacing={1}>
                {doctor?.doctor_workplace?.map((item, i) => (
                  <Chip label={item.workplace}></Chip>
                ))}
              </Stack>
            </Box>
            <FormHelperText id="component-error-text" error>
              {validateErrors?.workplace}
            </FormHelperText>

            <Box>
              <Autocomplete
                error={validateErrors?.division_id}
                options={allDivisions}
                fullWidth
                getOptionLabel={(option) => option.name}
                value={input.division_id}
                onChange={(e, data) => fieldChangeHandler("division_id", data)}
                renderInput={(params) => (
                  <TextField {...params} label="Select Division" />
                )}
              />
            </Box>
            <FormHelperText id="component-error-text" error>
              {validateErrors?.division_id}
            </FormHelperText>

            <Box mt={2}>
              <Autocomplete
                error={validateErrors?.district_id}
                // division paile sudhu oitari district show korbe..
                options={
                  allDistricts &&
                  allDistricts.filter(
                    (item) => item?.division_id === input?.division_id?._id
                  )
                }
                fullWidth
                getOptionLabel={(option) => option.name}
                value={input.district_id}
                onChange={(e, data) => fieldChangeHandler("district_id", data)}
                renderInput={(params) => (
                  <TextField {...params} label="Select District" />
                )}
              />
            </Box>
            <FormHelperText id="component-error-text" error>
              {validateErrors?.district_id}
            </FormHelperText>

            <Box mt={2}>
              <Autocomplete
                error={validateErrors?.sub_district_id}
                // district paile sudhu oitari sub district show korbe..
                options={
                  allSubDistricts &&
                  allSubDistricts.filter(
                    (item) => item?.district_id === input?.district_id?._id
                  )
                }
                fullWidth
                getOptionLabel={(option) => option.name}
                value={input.sub_district_id}
                onChange={(e, data) =>
                  fieldChangeHandler("sub_district_id", data)
                }
                renderInput={(params) => (
                  <TextField {...params} label="Select Sub District" />
                )}
              />
              {/* <FormControl fullWidth>
                <InputLabel id="demo-simple-select-label">
                  Sub-District
                </InputLabel>
                <Select
                  label="district"
                  value={input.sub_district_id}
                  error={validateErrors?.sub_district_id}
                  onChange={(e) =>
                    fieldChangeHandler("sub_district_id", e.target.value)
                  }
                >
                  {subDistricts?.map((item) => (
                    <MenuItem value={item.name}>{item.name}</MenuItem>
                  ))}
                </Select>
              </FormControl> */}
            </Box>
            <FormHelperText id="component-error-text" error>
              {validateErrors?.sub_district_id}
            </FormHelperText>

            <Box mt={2}>
              <FormControl fullWidth>
                <InputLabel id="demo-simple-select-label">
                  Working Department
                </InputLabel>
                <Select
                  label="working department"
                  value={input.working_department_id}
                  error={validateErrors?.working_department_id}
                  onChange={(e) =>
                    fieldChangeHandler("working_department_id", e.target.value)
                  }
                >
                  {departments?.data?.map((item) => (
                    <MenuItem value={item._id}>{item.name}</MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Box>
            <FormHelperText id="component-error-text" error>
              {validateErrors?.working_department_id}
            </FormHelperText>
            {/* <Box mt={2}>
                <TextField
                  id="outlined-basic"
                  label="Working Status"
                  variant="outlined"
                  fullWidth
                  value={input.working_status}
                  error={validateErrors?.working_status}
                  onChange={(e) =>
                    fieldChangeHandler("working_status", e.target.value)
                  }
                />
              </Box>
              <FormHelperText id="component-error-text" error>
                {validateErrors?.working_status}
              </FormHelperText> */}
          </>
        )}

        <Box mt={2}>
          <UploadButton
            label="Upload Image"
            value={input.image}
            onChange={imageChangeHandler}
          />
        </Box>
        <FormHelperText id="component-error-text" error>
          {validateErrors?.image}
        </FormHelperText>
        <Box sx={{ mt: 3 }}>
          {input?._id ? (
            <AddButton onClick={handleSubmit} type="submit">
              Update Doctor
            </AddButton>
          ) : (
            <AddButton onClick={handleSubmit} type="submit">
              Add Doctor
            </AddButton>
          )}
        </Box>
      </Box>
      {/* </form> */}
    </>
  );
};

export default AddDoctroDialog;
