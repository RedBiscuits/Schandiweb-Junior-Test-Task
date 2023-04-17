import { TextField } from "@mui/material";
export function fieldComponents(formik) {
  const ret = {
    dvd: ({ field }) => (
      <TextField
        error={!!(formik.touched.size && formik.errors.size)}
        fullWidth
        helperText={formik.touched.size && formik.errors.size}
        label="Size"
        name="size"
        onBlur={formik.handleBlur}
        onChange={formik.handleChange}
        type="text"
        value={formik.values.size}
      />
    ),
    furniture: ({ field }) => (
      <div>
        <TextField
          error={!!(formik.touched.height && formik.errors.height)}
          fullWidth
          helperText={formik.touched.height && formik.errors.height}
          label="Height"
          name="height"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="text"
          value={formik.values.height}
        />
        <TextField
          error={!!(formik.touched.width && formik.errors.width)}
          fullWidth
          helperText={formik.touched.width && formik.errors.width}
          label="Width"
          name="width"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="text"
          value={formik.values.width}
        />
        <TextField
          error={!!(formik.touched.length && formik.errors.length)}
          fullWidth
          helperText={formik.touched.length && formik.errors.length}
          label="Length"
          name="length"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="text"
          value={formik.values.length}
        />
      </div>
    ),
    book: ({ field }) => (
      <TextField
        error={!!(formik.touched.weight && formik.errors.weight)}
        fullWidth
        helperText={formik.touched.weight && formik.errors.weight}
        label="Weight"
        name="weight"
        onBlur={formik.handleBlur}
        onChange={formik.handleChange}
        type="text"
        value={formik.values.weight}
      />
    ),
  };
  return ret;
}
