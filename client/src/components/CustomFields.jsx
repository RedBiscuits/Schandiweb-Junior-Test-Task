import { Stack, TextField, Typography } from "@mui/material";
export function fieldComponents(formik) {
  const ret = {
    dvd: ({ field }) => (
      <Stack spacing={2}>
        <TextField
          error={!!(formik.touched.size && formik.errors.size)}
          fullWidth
          helperText={formik.touched.size && formik.errors.size}
          label="Size"
          id="#size"
          name="size"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="number"
          value={formik.values.size}
        />
        <Typography variant="h5" textAlign="center">
          Please specify DVD size (in MB).
        </Typography>
      </Stack>
    ),
    furniture: ({ field }) => (
      <Stack spacing={2}>
        <TextField
          error={!!(formik.touched.height && formik.errors.height)}
          fullWidth
          helperText={formik.touched.height && formik.errors.height}
          label="Height"
          name="height"
          id="height"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="number"
          value={formik.values.height}
        />
        <TextField
          error={!!(formik.touched.width && formik.errors.width)}
          fullWidth
          helperText={formik.touched.width && formik.errors.width}
          label="Width"
          name="width"
          id="width"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="number"
          value={formik.values.width}
        />
        <TextField
          error={!!(formik.touched.length && formik.errors.length)}
          fullWidth
          helperText={formik.touched.length && formik.errors.length}
          label="Length"
          name="length"
          id="length"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="number"
          value={formik.values.length}
        />
        <Typography variant="h5" textAlign="center">
          Please specify furniture dimensions (WxHxL).
        </Typography>
      </Stack>
    ),
    book: ({ field }) => (
      <Stack spacing={2}>
        <TextField
          error={!!(formik.touched.weight && formik.errors.weight)}
          fullWidth
          helperText={formik.touched.weight && formik.errors.weight}
          label="Weight"
          name="weight"
          id="weight"
          onBlur={formik.handleBlur}
          onChange={formik.handleChange}
          type="number"
          value={formik.values.weight}
        />
        <Typography variant="h5" textAlign="center">
          Please specify book weight (in KG).
        </Typography>
      </Stack>
    ),
  };
  return ret;
}
