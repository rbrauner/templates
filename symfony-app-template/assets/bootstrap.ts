import { startStimulusApp } from "@symfony/stimulus-bridge";
import { registerVueControllerComponents } from "@symfony/ux-vue";

export const app = startStimulusApp(
    require.context(
        "@symfony/stimulus-bridge/lazy-controller-loader!./controllers",
        true,
        /\.[jt]sx?$/,
    ),
);

registerVueControllerComponents(
    require.context("./vue/controllers", true, /\.vue$/),
);
