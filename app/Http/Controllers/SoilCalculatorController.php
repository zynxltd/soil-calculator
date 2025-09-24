<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Contracts\SoilCalculationServiceInterface;
use App\Contracts\BagOptimizationServiceInterface;
use App\Contracts\UnitConversionServiceInterface;

/**
 * Soil Calculator Controller
 * 
 * Handles HTTP requests for soil calculation, bag optimization, and unit conversions.
 * Follows SOLID principles with dependency injection and single responsibility.
 */
class SoilCalculatorController extends Controller
{
    public function __construct(
        private SoilCalculationServiceInterface $calculationService,
        private BagOptimizationServiceInterface $optimizationService,
        private UnitConversionServiceInterface $conversionService
    ) {}

    /**
     * Display the soil calculator form
     */
    public function index()
    {
        return view('soil-calculator');
    }

    /**
     * Calculate soil requirements and optimal bag combination
     * 
     * @param Request $request Contains length, width, depth, soil_type, optimize_by
     * @return JsonResponse Calculation results with bag combination and costs
     */
    public function calculate(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateCalculationRequest($request);

            // Delegate business logic to services
            $volume = $this->calculationService->calculateVolume(
                $validated['length'],
                $validated['width'],
                $validated['depth']
            );

            $soilRequired = $this->calculationService->calculateSoilRequired(
                $volume,
                $validated['soil_type']
            );

            $bagCombination = $this->optimizationService->findOptimalCombination(
                $soilRequired,
                $validated['optimize_by'] ?? 'wastage'
            );

            return $this->buildSuccessResponse($volume, $soilRequired, $bagCombination);

        } catch (ValidationException $e) {
            return $this->buildValidationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->buildErrorResponse($e, $request);
        }
    }

    /**
     * Validate calculation request
     */
    private function validateCalculationRequest(Request $request): array
    {
        $limits = config('soil.limits');
        
        return $request->validate([
            'length' => 'required|numeric|min:' . $limits['min_dimension'] . '|max:' . $limits['max_length_width'],
            'width' => 'required|numeric|min:' . $limits['min_dimension'] . '|max:' . $limits['max_length_width'],
            'depth' => 'required|numeric|min:' . $limits['min_dimension'] . '|max:' . $limits['max_depth'],
            'soil_type' => 'required|in:intensive,extensive',
            'optimize_by' => 'sometimes|in:wastage,cost',
        ], [
            'length.required' => 'Length is required',
            'length.numeric' => 'Length must be a number',
            'length.min' => 'Length must be at least ' . $limits['min_dimension'] . ' meters',
            'length.max' => 'Length cannot exceed ' . number_format($limits['max_length_width']) . ' meters',
            'width.required' => 'Width is required',
            'width.numeric' => 'Width must be a number',
            'width.min' => 'Width must be at least ' . $limits['min_dimension'] . ' meters',
            'width.max' => 'Width cannot exceed ' . number_format($limits['max_length_width']) . ' meters',
            'depth.required' => 'Depth is required',
            'depth.numeric' => 'Depth must be a number',
            'depth.min' => 'Depth must be at least ' . $limits['min_dimension'] . ' meters',
            'depth.max' => 'Depth cannot exceed ' . $limits['max_depth'] . ' meters',
            'soil_type.required' => 'Soil type is required',
            'soil_type.in' => 'Please select a valid soil type',
        ]);
    }

    /**
     * Build success response
     */
    private function buildSuccessResponse(float $volume, float $soilRequired, array $bagCombination): JsonResponse
    {
        $cubicMeters = round($volume, 2);
        $liters = $this->calculationService->calculateLiters($volume);

        return response()->json([
            'success' => true,
            'data' => [
                'cubic_meters' => $cubicMeters,
                'liters' => $liters,
                'soil_required_kg' => round($soilRequired, 2),
                'bag_combination' => $bagCombination,
                'total_cost' => $bagCombination['total_cost'],
                'wastage_percentage' => $bagCombination['wastage_percentage'],
            ]
        ]);
    }

    /**
     * Build validation error response
     */
    private function buildValidationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
            'message' => 'Please check your input and try again.'
        ], 422);
    }

    /**
     * Build error response
     */
    private function buildErrorResponse(\Exception $e, Request $request): JsonResponse
    {
        \Log::error('Soil Calculator Error: ' . $e->getMessage(), [
            'request' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred during calculation. Please try again.'
        ], 500);
    }

    /**
     * Get available soil types
     */
    public function getSoilTypes(): JsonResponse
    {
        return response()->json($this->calculationService->getSoilTypes());
    }

    /**
     * Convert units between metric and imperial
     */
    public function convertUnits(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'value' => 'required|numeric|min:0',
                'from_unit' => 'required|in:meters,feet,inches',
                'to_unit' => 'required|in:meters,feet,inches',
            ]);

            $result = $this->conversionService->convert(
                $validated['value'],
                $validated['from_unit'],
                $validated['to_unit']
            );

            return response()->json([
                'success' => true,
                'result' => round($result, 4),
                'from_unit' => $validated['from_unit'],
                'to_unit' => $validated['to_unit'],
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Invalid conversion parameters.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed.'
            ], 500);
        }
    }
}